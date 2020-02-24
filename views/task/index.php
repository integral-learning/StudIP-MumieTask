<?php
$widget = new SidebarWidget;
$widget->title = dgettext("MumieTask",'Informationen');
$factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
if($task->duedate) {
    $duedateInfo = $factory->open("taskInfo");
    $duedateInfo->set_attribute("header", dgettext("MumieTask",'Abgabefrist'));
    $duedateInfo->set_attribute(
        "body", 
        sprintf(
            '%s  %s',
            Icon::create('date'),
            date('d.m.Y H:i',$task->duedate)
        )
    );
    $widget->addElement(
        new WidgetElement(
            $duedateInfo->render()
        )
    );
}

if($hasTeacherPermission = PermissionService::hasTeacherPermission()) {
    $actions = new ActionsWidget();
    $actions->addLink(
        dgettext('Mumietask','Übersicht'),
        PluginEngine::getLink('MumieTaskPlugin', array("task_id" => $task->task_id), 'task'),
        Icon::create('assessment')
    );
    $actions->addLink(
        dgettext('Mumietask','Bewertungen'),
        PluginEngine::getLink('MumieTaskPlugin', array("task_id" => $task->task_id), 'task/gradeOverview'),
        Icon::create('ranking')
    );
    Sidebar::Get()->addWidget($actions);
} else {
    $points = MumieGrade::getGradeForUser($task["task_id"], $GLOBALS['user']->id)->points;
    $gradeTemplate = $factory->open('grade.php');
    $gradeTemplate->set_attribute('points', $points);
    
    $gradeInfo = $factory->open("taskInfo");
    $gradeInfo->set_attribute("header", dgettext("MumieTask",'Bewertung'));
    $gradeInfo->set_attribute("body", $gradeTemplate->render());
                
    $widget->addElement(
        new WidgetElement(
            $gradeInfo->render()
        )
    );
    
    $passed = $factory->open("taskInfo");
    $passed->set_attribute("header", dgettext("MumieTask",'Bestanden'));
    $passed->set_attribute("body", $points >= $task["passing_grade"] ? Icon::create('check-circle', 'status-green') : Icon::create('decline',  'status-red'));
    $widget->addElement(
        new WidgetElement(
            $passed->render()
        )
    );
}


$passingGrade = $factory->open("taskInfo");
$passingGrade->set_attribute("header", dgettext("MumieTask",'Mindestpunktzahl'));
$passingGrade->set_attribute("body", $task["passing_grade"]);
$widget->addElement(
    new WidgetElement(
        $passingGrade->render()
    )
);
Sidebar::get()->addWidget($widget);

?>


<section class="contentbox">
    <section>

        <header>
            <h1><?= dgettext("MumieTask", "Inhalt") ?></h1>
        </header>
        <div>TODO: Hier text einfügen, der darauf hinweist, dass auf eine externe Seite verlinkt ist</div>
        <?php if($task->launch_container == 0) : ?>
        <a href=<?= PluginEngine::getLink("MumieTaskPlugin", array("task_id" => $task->task_id), 'task/launch'); ?>
            target="_blank" class="button">Anzeigen</a>
        <?php else : ?>
        <iframe width='90%' height='100%'
            src=<?= PluginEngine::getLink("MumieTaskPlugin", array("task_id" => $task->task_id), 'task/launch'); ?>
            webkitallowfullscreen mozallowfullscreen allowfullscreen>
        </iframe>
        <?php endif;?>
    </section>
</section>