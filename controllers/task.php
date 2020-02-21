<?php 
require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieHash.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/PermissionService.php');

class TaskController extends StudipController {
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/course/mumietask');
        $this->hasTeacherPermission = PermissionService::hasTeacherPermission();
    }
    public function index_action() {
        $this->task = MumieTask::find(Request::option("task_id"));
    }

    public function launch_action() {
        $this->task = MumieTask::find(Request::option("task_id"));
        $this->mumieToken = SSOService::generateTokenForUser($GLOBALS['user']->id);
        $this->org = Config::get()->MUMIE_ORG;
    }

    public function gradeOverview_action() {
        $this->task = MumieTask::find(Request::option("task_id"));
        $this->grades = MumieGrade::getAllGradesForTaskWithRealNames(Request::option("task_id"));
    }
}