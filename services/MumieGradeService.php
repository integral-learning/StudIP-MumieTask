<?php
/**
 * This file is part of the MumieTaskPlugin for StudIP.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 3 of
 * the License, or (at your option) any later version.
 *
 * @author      Tobias Goltz <tobias.goltz@integral-learning.de>
 * @copyright   2020 integral-learning GmbH (https://www.integral-learning.de/)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category    Stud.IP
 */

require_once('HashingService.php');
/**
 * MumieGradeService synchronizes grades StudIP users have earned on the MUMIE LMS with the StudIP database.
 */
class MumieGradeService
{
    /**
     * The userIds we want to get grades for
     *
     * @var string[]
     */
    private $user_ids;
    /**
     * All MUMIE Tasks we want to get grades for
     *
     * @var MumieTask[]
     */
    private $tasks;
    /**
     * If an update is forced, existing data will always be replaced by the latest grade from the server
     *
     * @var boolean
     */
    private $force_update;
    /**
     * The course we want to update
     *
     * @var mixed
     */
    private $courseId;
    
    /**
     * __construct
     *
     * @param  string $courseId
     * @param  MumieTask[] $tasks
     * @param  string[] $userIds
     * @param  boolean $force_update
     * @return void
     */
    public function __construct($courseId, $tasks = null, $userIds = null, $force_update = false)
    {
        $this->courseId = $courseId;
        $this->force_update = $force_update;
        $this->user_ids = $userIds ?? $this->getAllUsers($courseId);
        $this->tasks = $tasks ?? MumieTask::findAllInCourse($courseId);
    }

    /**
     * SyncIds are composed of a hashed StudIP user id and a shorthand for the organization that operates the StudIP platfrom.
     *
     * They must be a unique identifier for users on both StudIP and MUMIE servers
     *
     * @param  string[] $user_ids
     * @return string[]
     */
    private function getSyncIds($user_ids)
    {
        return array_map(function ($user_id) {
            $hashed_user = HashingService::getHash($user_id)->hash;
            return "GSSO_" . Config::get()->MUMIE_ORG . "_" . $hashed_user;
        }, $user_ids);
    }

    /**
     * Get the studip user ID from a xapi grade
     *
     * @param  stdClass $xapiGrade
     * @return string
     */
    private function getStudIPId($xapiGrade)
    {
        $hashed_user = substr(strrchr($xapiGrade->actor->account->name, "_"), 1);
        return HashingService::getUserIdFromHash($hashed_user);
    }

    /**
     * get a map of xapi grades by user
     *
     * @param  MumieTask $task
     * @return array
     */
    public function getXapiGradesByUser($task)
    {
        $params = array(
            "users" => $this->getSyncIds($this->user_ids),
            "course" => $task->mumie_coursefile,
            "objectIds" => array(self::getMumieId($task)),
            'lastSync' => $this->getLastSync($task),
            'includeAll' => true
        );

        $payload = json_encode($params);

        $ch = curl_init(MumieServerInstance::fromUrl($task->server)->getGradeSyncURL());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_USERAGENT, "My User Agent Name");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
            "X-API-Key: " . Config::get()->MUMIE_API_KEY,
        )
        );
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $this->getValidGradeByUser($response, $task);
    }
    
    /**
     * Get the unique identifier for a MUMIE task
     *
     * @param stdClass $mumietask
     * @return string id for MUMIE task on MUMIE server
     */
    private function getMumieId($mumietask)
    {
        $id = $mumietask->task_url;
        $prefix = "link/";
        if (strpos($id, $prefix) !== false) {
            $id = substr($mumietask->taskurl, strlen($prefix));
        }
        return $id;
    }


    /**
     * Get a timestamp from the last grade synchronization.
     *
     * LastSync is used to improve performance. We don't need to check grades that were awarded before the last time we synced
     *
     * @param  MumieTask $task
     * @return int
     */
    private function getLastSync($task)
    {
        if ($this->force_update) {
            return 1;
        }

        $oldest_timestamp = PHP_INT_MAX;
        $grades = MumieGrade::findBySQL("task_id = ?", array($task->id));
        if (count($grades) < count($this->user_ids)) {
            return 1;
        }
        foreach ($grades as $grade) {
            if ($grade->timechanged < $oldest_timestamo) {
                $oldest_timestamp = $grade->timechanged;
            }
        }

        if ($oldest_timestamp == PHP_INT_MAX) {
            $oldest_timestamp = 1;
        }
        return $oldest_timestamp * 1000;
    }

    /**
     * Get all users that can get marks in this course
     *
     * @param  string $courseId
     * @return void
     */
    private function getAllUsers($courseId)
    {
        $query = "Select user_id from seminar_user where seminar_id = ? AND status = 'autor'";
        return DBManager::get()->fetchAll($query, array($courseId));
    }

    /**
     * A user can submit multiple solutions to MUMIE Tasks.
     *
     * Filter out grades that were earned after the due date. Other than that, select always the latest grade
     *
     * @param  stdClass $response MUMIE Server response for grade sync request
     * @param  MumieTask $task
     * @return array
     */
    private function getValidGradeByUser($response, $task)
    {
        $grades_by_user = new stdClass();
        if ($response) {
            foreach ($response as $xapi_grade) {
                if (!is_array($grades_by_user->{$this->getStudIPId($xapi_grade)})) {
                    $grades_by_user->{$this->getStudIPId($xapi_grade)} = array();
                }
                array_push($grades_by_user->{$this->getStudIPId($xapi_grade)}, $xapi_grade);
            }
        }
        
        $valid_grade_by_user = array();
        foreach ($grades_by_user as $user_id => $xapi_grades) {
            $xapi_grades = array_filter($xapi_grades, function ($grade) use ($task) {
                if (!$task->duedate || $task->duedate == 0) {
                    return true;
                }
                return strtotime($grade->timestamp) <= $task->duedate;
            });
            $valid_grade_by_user[$user_id] = $this->getLatestGrade($xapi_grades);
        }

        return array_filter($valid_grade_by_user);
    }
    
    /**
     * Get the latest grade from a list of grades
     *
     * @param  stdClass[] $xapi_grades
     * @return stdClass
     */
    private function getLatestGrade($xapi_grades)
    {
        if (empty($xapi_grades)) {
            return null;
        }
        $latest_grade = $xapi_grades[0];

        foreach ($xapi_grades as $grade) {
            if (strtotime($grade->timestamp)> strtotime($latest_grade->timestamp)) {
                $latest_grade = $grade;
            }
        }
        return $latest_grade;
    }
    
    /**
     * Load MUMIE grades into StudIP database.
     *
     * @return void
     */
    public function update()
    {
        foreach ($this->tasks as $task) {
            $this->updateGrades($task);
        }
    }
    
    /**
     * Update grades for a given MUMIE Task
     *
     * @param  MumieTask $task
     * @return void
     */
    private function updateGrades($task)
    {
        $gradesByUser = $this->getXapiGradesByUser($task);
        foreach (array_keys($gradesByUser) as $userId) {
            $xapiGrade = $gradesByUser[$userId];
            $percentage = round($xapiGrade->result->score->scaled * 100);
            if ($mumieGrade = MumieGrade::getGradeForUser($task->task_id, $userId)) {
                $mumieGrade->points = $percentage;
                $mumieGrade->store();
            } else {
                $mumieGrade = new MumieGrade();
                $mumieGrade->the_user = $userId;
                $mumieGrade->task_id = $task->task_id;
            }
            $mumieGrade->timechanged = strtotime($xapiGrade->timestamp);
            $mumieGrade->points = $percentage;
            $mumieGrade->store();
        }
    }
}
