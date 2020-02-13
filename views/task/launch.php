<?php $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('launch.php');
    /* The PluginEngine must be used here. 
    If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */

    $serverInstance = new MumieServerInstance(MumieServer::getByUrl($task->server));
    $template->set_attribute('loginUrl', $serverInstance->getLoginUrl());
    $template->set_attribute('task', $task);
    $template->set_attribute('ssotoken', $mumieToken);
    $template->set_attribute('org', $org);
    echo $template->render();

?>