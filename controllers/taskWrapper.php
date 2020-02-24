<?php 
require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieHash.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/PermissionService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/MumieGradeService.php');
// TODO: Check how can access this

class TaskWrapperController extends StudipController {
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/course/mumietask');
        $this->hasTeacherPermission = PermissionService::hasTeacherPermission();

        $gradeService = new MumieGradeService(\Context::get()->Seminar_id);
        $gradeService->updateGradesForAllTasks();
    }
    public function index_action() {
        $this->tasks = MumieTask::findAllInCourse(\Context::get()->Seminar_id);
        if($this->hasTeacherPermission) {
            $actions = new ActionsWidget();
            $actions->addLink(
                dgettext('Mumietask','Neue MUMIE-Task anlegen'),
                $this->url_for('taskWrapper/addTask'),
                Icon::create('add')
            );
    
            Sidebar::Get()->addWidget($actions);
        }
    }

    public function addTask_action() {
        PermissionService::requireTeacherPermission();
        $this->structuredServers = MumieServerInstance::getAllWithStructure();
        if(Request::isPost()) {
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
            $task->duedate = Request::get('duedate');
            $task->passing_grade = Request::get('passing_grade');
            
            $errors = $this->getFormValidationErrors($task);
            if(count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $task->store();
                PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'MUMIE-Task erfolgreich hinzugefügt') . '!'));
                $this->redirect('taskWrapper/index');
            }


        }
    }

    public function deleteTask_action() {
        PermissionService::requireTeacherPermission();
        $task = MumieTask::find(Request::option("task_id"));
        $task->delete();
        PageLayout::postMessage(
            MessageBox::success(dgettext('MumieServer', 'MUMIE-Task wurde gelöscht') . '!')
        );
        $this->redirect(PluginEngine::getURL("MumieTaskPlugin", array(), 'taskWrapper/index'));
    }

    public function editTask_action() {
        PermissionService::requireTeacherPermission();
        $this->task = MumieTask::find(Request::option("task_id"));
        $this->structuredServers = MumieServerInstance::getAllWithStructure();
        if(Request::isPost()) {
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
            $task->duedate = Request::get('duedate');
            $task->passing_grade = Request::get('passing_grade');
            
            $errors = $this->getFormValidationErrors($task);
            if(count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $task->store();
                PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'MUMIE-Task erfolgreich hinzugefügt') . '!'));
                $this->redirect('taskWrapper/index');
            }
        }
    }

    private function getFormValidationErrors($task) {
        $server = MumieServer::getByUrl($task->server);
        
        if($server == null || !(new MumieServerInstance($server))->isValidMumieServer()) {
            $errors[] = dgettext('MumieTask', 'Der gewählte MUMIE-Server konnte nicht gefunden werden.');
            return $errors;
        }

        $serverInstance = new MumieServerInstance($server);
        $serverInstance->loadStructure();
        $course = $serverInstance->getCoursebyName($task->mumie_course);

        if($course == null) {
            $errors[] = dgettext('MumieTask', 'Dieser Kurs konnte auf dem ausgewählten server nicht gefunden werden.1');
            return $errors;
        }

        if($course == null || $task->mumie_coursefile == null) {
            $errors[] = dgettext('MumieTask', 'Dieser Kurs konnte auf dem ausgewählten server nicht gefunden werden.2222');
            return $errors;
        }

        $problem = $course->getTaskByLink($task->task_url);
        if($problem == null) {
            $errors[] = dgettext('MumieTask', 'Das gewählte MUMIE-Problem konnte nicht gefunden werden.');
            return $errors;
        }
        
        if(!in_array($task->language, $problem->getLanguages())) {
            $errors[] =  dgettext('MumieTask', 'Es gibt keine Übersetzung in die gewünschte Sprache für das ausgewählte Problem');
            return $errors;
        }
        
    }
}