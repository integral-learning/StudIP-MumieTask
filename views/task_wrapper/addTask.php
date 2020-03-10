<h1>
    <?= dgettext("MumieTaskPlugin", "Neue MUMIE-Task erstellen"); ?>
</h1>
<br>
<?php
    require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/TaskOptionCollector.php');
    $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('TaskForm.php');
    $collector = new TaskOptionCollector($structuredServers);
    $collector->collect();
    $template->set_attribute("serverStructure", $structuredServers);
    $template->set_attribute("collector", $collector);
    $lang = getUserLanguage($GLOBALS['user']->id);
    $lang = substr($lang, 0, strpos($lang, "_"));
    $template->set_attribute("language", $lang);
    /* The PluginEngine must be used here.
       If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */
    $template->set_attribute(
        'action',
        PluginEngine::getLink(
            'MumieTaskPlugin',
            array(),
            'taskWrapper/addTask'
        )
    );
    $template->set_attribute(
        'cancelLink',
        PluginEngine::getLink(
            'MumieTaskPlugin',
            array(),
            'taskWrapper/index'
        )
    );
    echo $template->render();
?>