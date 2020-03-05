<?php $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('launch.php');
    $serverInstance = new MumieServerInstance(MumieServer::getByUrl($task->server));
    $template->set_attribute('loginUrl', $serverInstance->getLoginUrl());
    $template->set_attribute('task', $task);
    $template->set_attribute('ssotoken', $mumieToken);
    $template->set_attribute('org', $org);
    echo $template->render();
?>