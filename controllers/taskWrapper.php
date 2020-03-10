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

require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieHash.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/PermissionService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/MumieGradeService.php');

/**
 * TaskWrapperController is used to add, edit, delete MUMIE tasks and display all tasks of the current course in a list view.
 */
class TaskWrapperController extends StudipController
{
    /**
     * Check permissions, manage navigation and set title.
     *
     * @param  mixed $action
     * @param  mixed $args
     * @return void
     */
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/course/mumietask');
        $this->hasTeacherPermission = PermissionService::hasTeacherPermission();
        PageLayout::setTitle(dgettext("MumieTaskPlugin", "MUMIE-Task") . ": " . dgettext("MumieTaskPlugin", "Aufgabenübersicht"));
    }
        
    /**
     * Display all MUMIE Tasks in this course in a table with updated grades.
     *
     * @return void
     */
    public function index_action()
    {
        $this->tasks = MumieTask::findAllInCourse(\Context::get()->Seminar_id);
        if ($this->hasTeacherPermission) {
            $actions = new ActionsWidget();
            $actions->addLink(
                dgettext('MumieTaskPlugin', 'MUMIE-Task hinzufügen'),
                $this->url_for('taskWrapper/addTask'),
                Icon::create('add')
            );
            
            Sidebar::Get()->addWidget($actions);
        }
        $gradeService = new MumieGradeService(\Context::get()->Seminar_id);
        $gradeService->update();
    }
    
    /**
     * Open/submit forms for adding MUMIE tasks to the current course.
     *
     * @return void
     */
    public function addTask_action()
    {
        PermissionService::requireTeacherPermission();
        $this->structuredServers = MumieServerInstance::getAllWithStructure();
        if (Request::isPost()) {
            $task = new MumieTask();
            $task->name = Request::get('name');
            $task->server = Request::get('server');
            $task->task_url = Request::get('task_url');
            $task->launch_container = Request::get('launch_container');
            $task->mumie_course = Request::get('course');
            $task->language = Request::get('language');
            $task->mumie_coursefile = Request::get('coursefile');
            $task->course = \Context::get()->Seminar_id;
            $task->privategradepool = !Request::get('private_gradepool');
            $task->duedate = strtotime(Request::get('duedate'));
            $task->passing_grade = Request::get('passing_grade');

            $errors = $this->getFormValidationErrors($task);
            if (count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $task->store();
                PageLayout::postMessage(MessageBox::success(dgettext('MumieTaskPlugin', 'MUMIE-Task erfolgreich hinzugefügt') . '!'));
                $this->redirect('taskWrapper/index');
            }
        }
    }
    
    /**
     * Delete a given MUMIE Task from the current course.
     * The task_id is found in POST request
     *
     * @return void
     */
    public function deleteTask_action()
    {
        PermissionService::requireTeacherPermission();
        $task = MumieTask::find(Request::option("task_id"));
        $task->delete();
        PageLayout::postMessage(
            MessageBox::success(dgettext('MumieTaskPlugin', 'MUMIE-Task wurde gelöscht') . '!')
        );
        $this->redirect(PluginEngine::getURL("MumieTaskPlugin", array(), 'taskWrapper/index'));
    }
    
    /**
     * Open/submit a form for editing given MUMIE tasks
     * The task_id is found in POST request
     *
     * @return void
     */
    public function editTask_action()
    {
        PermissionService::requireTeacherPermission();
        $this->task = MumieTask::find(Request::option("task_id"));
        $this->structuredServers = MumieServerInstance::getAllWithStructure();
        if (Request::isPost()) {
            $task = MumieTask::find(Request::option("task_id"));
            $task->name = Request::get('name');
            $task->server = Request::get('server');
            $task->task_url = Request::get('task_url');
            $task->launch_container = Request::get('launch_container');
            $task->mumie_course = Request::get('course');
            $task->language = Request::get('language');
            $task->mumie_coursefile = Request::get('coursefile');
            $task->course = \Context::get()->Seminar_id;
            $task->privategradepool = !Request::get('private_gradepool');
            $task->duedate = strtotime(Request::get('duedate'));
            $task->passing_grade = Request::get('passing_grade');
            
            $errors = $this->getFormValidationErrors($task);
            if (count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $task->store();
                PageLayout::postMessage(MessageBox::success(dgettext('MumieTaskPlugin', 'MUMIE-Task erfolgreich hinzugefügt') . '!'));
                $this->redirect('taskWrapper/index');
            }
        }
    }
    
    /**
     * Validate submitted form parameters
     *
     * @param  MumieTask $task
     * @return string[] List of errors
     */
    private function getFormValidationErrors($task)
    {
        $server = MumieServer::getByUrl($task->server);
        
        $errors = array();
        if ($task->isFieldDirty('duedate') && $task->duedate != 0 && $task->duedate < time()) {
            $errors[] =  dgettext('MumieTaskPlugin', 'Das Datum der Abgabefrist muss in der Zukunft liegen!');
        }

        if ($server == null || !(new MumieServerInstance($server))->isValidMumieServer()) {
            $errors[] = dgettext('MumieTaskPlugin', 'Der gewählte MUMIE-Server konnte nicht gefunden werden.');
            return $errors;
        }

        $serverInstance = new MumieServerInstance($server);
        $serverInstance->loadStructure();
        $course = $serverInstance->getCoursebyName($task->mumie_course);

        if ($course == null) {
            $errors[] = dgettext('MumieTaskPlugin', 'Dieser Kurs konnte auf dem ausgewählten server nicht gefunden werden.');
            return $errors;
        }

        if ($course == null || $task->mumie_coursefile == null) {
            $errors[] = dgettext('MumieTaskPlugin', 'Dieser Kurs konnte auf dem ausgewählten server nicht gefunden werden.');
            return $errors;
        }

        $problem = $course->getTaskByLink($task->task_url);
        if ($problem == null) {
            $errors[] = dgettext('MumieTaskPlugin', 'Das gewählte MUMIE-Problem konnte nicht gefunden werden.');
            return $errors;
        }
        
        if (!in_array($task->language, $problem->getLanguages())) {
            $errors[] =  dgettext('MumieTaskPlugin', 'Es gibt keine Übersetzung in die gewünschte Sprache für das ausgewählte Problem.');
            return $errors;
        }
        return $errors;
    }
}
