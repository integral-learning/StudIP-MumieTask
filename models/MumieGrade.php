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

/**
 * MumieGrade is a single grade for a MUMIE Task awared to a student
 */
class MumieGrade extends SimpleORMap
{
    /**
     * configure
     *
     * @param  mixed $config
     * @return void
     */
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_grades';
        parent::configure($config);
    }
    
    /**
     * Get a students grade for a given MUMIE task.
     *
     * @param  string $taskId
     * @param  string $userId
     * @return MumieGrade
     */
    public static function getGradeForUser($taskId, $userId)
    {
        return self::findOneBySQL("task_id = ? AND the_user = ?", array($taskId, $userId));
    }
    
    /**
     * Get grades for a given task of all students. Also include their names in the data set.
     *
     * @param  MumieTask $task
     * @return stdClass[]
     */
    public static function getAllGradesForTaskWithRealNames($task)
    {
        $query = "SELECT Vorname, Nachname, points  
            FROM seminar_user 
                JOIN auth_user_md5 ON (seminar_user.user_id = auth_user_md5.user_id) 
                LEFT OUTER JOIN (SELECT * FROM mumie_grades WHERE task_id = ?) AS mumie_grades ON (seminar_user.user_id = mumie_grades.the_user)
            WHERE seminar_id = ? AND status = 'autor'
        ORDER BY Nachname, Vorname
        ";
        return DBManager::get()->fetchAll($query, array($task->task_id, $task->course));
    }
    
    /**
     * Delete all grades from the database that were saved for a given MUMIE-Task
     *
     * @param  MumieTask $task
     * @return void
     */
    public static function deleteAllGradesForTask($task)
    {
        $grades = self::findBySQL("task_id = ?", array($task->task_id));
        foreach ($grades as $grade) {
            $grade->delete();
        }
    }
}
