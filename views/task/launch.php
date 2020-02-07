<?php $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('launch.php');
    /* The PluginEngine must be used here. 
    If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */
    $template->set_attribute('task', $task);
    echo $template->render();

?>