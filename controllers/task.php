<?php 
require_once('app/controllers/plugin_controller.php');

// TODO: Make sure that only admins have access

class TaskController extends StudipController {
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/course/mumietask');
    }
    public function index_action() {
        $actions = new ActionsWidget();
        $actions->addLink(
            dgettext('Mumietask','Neue MUMIE-Task anlegen'),
            $this->url_for('task/addTask'),
            Icon::create('add')
        )->asDialog('size=50%');

        Sidebar::Get()->addWidget($actions);
    }

    public function addTask_action() {
        if(Request::isPost()) {
            $task = new MumieTask();
            $task->name = Request::get('name');
            $task->server = Request::get('server');
            $task->task_url = Request::get('task_url');
            $task->launch_container = Request::get('launch_container');
            $task->mumie_course = Request::get('course');
            $task->language = Request::get('language');
            $task->course = 1;
            $task->store();
        }
    }
}