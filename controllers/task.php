<?php
require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieHash.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/PermissionService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/MumieGradeService.php');

class TaskController extends StudipController
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/course/mumietask');
        $this->hasTeacherPermission = PermissionService::hasTeacherPermission();
        // There is a bug in navigation, where params are not properly encoded/decoded. That's why we need to check for two parameters.
        $task_id = Request::option("task_id")  === "" ? Request::option("amp;task_id") : Request::option("task_id");
        $this->task = MumieTask::find($task_id);
        PageLayout::setTitle(dgettext("MumieTaskPlugin", "MUMIE-Task") . ": " .$this->task->name);
    }

    public function index_action()
    {
        $this->addSidebar();
        if ($this->hasTeacherPermission) {
            Navigation::activateItem('/course/mumietask/task');
        }
        $gradeService = new MumieGradeService(\Context::get()->Seminar_id, array($this->task), array($GLOBALS['user']->id));
        $gradeService->update();
    }

    public function launch_action()
    {
        $this->mumieToken = SSOService::generateTokenForUser($GLOBALS['user']->id);
        $this->org = Config::get()->MUMIE_ORG;
    }

    public function gradeOverview_action()
    {
        $this->addSidebar();
        if ($this->hasTeacherPermission) {
            Navigation::activateItem('/course/mumietask/grades');
        }
        $this->grades = MumieGrade::getAllGradesForTaskWithRealNames(Request::option("task_id"));
        $gradeService = new MumieGradeService(\Context::get()->Seminar_id, array($this->task));
        $gradeService->update();
    }

    private function addSidebar()
    {
        $widget = new SidebarWidget;
        $widget->title = dgettext("MumieTaskPlugin", 'Informationen');
        $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');

        $dateString = $this->task->duedate == 0 ?
            "-" :
            sprintf(
                '%s  %s',
                Icon::create('date'),
                date('d.m.Y H:i', $this->task->duedate)
            );
        $duedateInfo = $factory->open("taskInfo");
        $duedateInfo->set_attribute("header", dgettext("MumieTask", 'Abgabefrist'));
        $duedateInfo->set_attribute(
            "body",
            $dateString
        );
        $widget->addElement(
            new WidgetElement(
                $duedateInfo->render()
            )
        );

        if ($this->hasTeacherPermission = PermissionService::hasTeacherPermission()) {
            $navigation = Navigation::getItem('/course/mumietask');
            $navigation->addSubNavigation(
                'task',
                new Navigation(
                    dgettext("MumieTaskPlugin", "Aufgabe"),
                    PluginEngine::getLink(
                        'MumieTaskPlugin',
                        array("task_id" => $this->task->task_id),
                        'task'
                    )
                )
            );
            $navigation->addSubNavigation(
                'grades',
                new Navigation(
                    dgettext("MumieTaskPlugin", "Bewertungen"),
                    PluginEngine::getLink(
                        'MumieTaskPlugin',
                        array("task_id" => $this->task->task_id),
                        'task/gradeOverview'
                    )
                )
            );
        } else {
            $points = MumieGrade::getGradeForUser($this->task["task_id"], $GLOBALS['user']->id)->points;
            $gradeTemplate = $factory->open('grade.php');
            $gradeTemplate->set_attribute('points', $points);
            
            $gradeInfo = $factory->open("taskInfo");
            $gradeInfo->set_attribute("header", dgettext("MumieTaskPlugin", 'Bewertung'));
            $gradeInfo->set_attribute("body", $gradeTemplate->render());
                        
            $widget->addElement(
                new WidgetElement(
                    $gradeInfo->render()
                )
            );
            
            $passed = $factory->open("taskInfo");
            $passed->set_attribute("header", dgettext("MumieTaskPlugin", 'Bestanden'));
            $passed->set_attribute("body", $points >= $this->task["passing_grade"] ? Icon::create('check-circle', 'status-green') : Icon::create('decline', 'status-red'));
            $widget->addElement(
                new WidgetElement(
                    $passed->render()
                )
            );
        }


        $passingGrade = $factory->open("taskInfo");
        $passingGrade->set_attribute("header", dgettext("MumieTaskPlugin", 'Mindestpunktzahl'));
        $passingGrade->set_attribute("body", $this->task["passing_grade"]);
        $widget->addElement(
            new WidgetElement(
                $passingGrade->render()
            )
        );
        Sidebar::get()->addWidget($widget);
    }
}
