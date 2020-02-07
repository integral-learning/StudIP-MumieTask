<?php 
require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');

// TODO: Make sure that only admins have access

class TaskController extends StudipController {
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/course/mumietask');
    }
    public function index_action() {
        $this->tasks = MumieTask::findBySQL("task_id>0");
        $actions = new ActionsWidget();
        $actions->addLink(
            dgettext('Mumietask','Neue MUMIE-Task anlegen'),
            $this->url_for('task/addTask'),
            Icon::create('add')
        )->asDialog('size=50%');

        Sidebar::Get()->addWidget($actions);
    }

    public function addTask_action() {
        $this->structuredServers = MumieServerInstance::getAllWithStructure();
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

            PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'MUMIE-Task erfolgreich hinzugefügt') . '!'));
            $this->redirect('task/index');

        }
    }

    public function deleteTask_action() {
        $task = MumieTask::find(Request::option("task_id"));
        $task->delete();
        PageLayout::postMessage(
            MessageBox::success(dgettext('MumieServer', 'MUMIE-Task wurde gelöscht') . '!')
        );
        $this->redirect(PluginEngine::getURL("MumieTaskPlugin", array(), 'task/index'));
    }

    public function editTask_action() {

    }

    public function displayTask_action() {
        $this->task = MumieTask::find(Request::option("task_id"));

    }

    public function launch_action() {
        $this->task = MumieTask::find(Request::option("task_id"));

    }

}