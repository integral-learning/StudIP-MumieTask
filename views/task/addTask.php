<?php 
    require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/TaskOptionCollector.php');
    $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('TaskForm.php');
    $collector = new TaskOptionCollector($structuredServers);
    $collector->collect();
    $template->set_attribute("serverStructure", $structuredServers);
    $template->set_attribute("collector", $collector);
    /* The PluginEngine must be used here. 
       If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */
    $template->set_attribute('action', PluginEngine::getLink('MumieTaskPlugin', array(), 'task/addTask'));
    echo $template->render();
    
?>

