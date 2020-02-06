<?php 

    $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTask')->getPluginPath() . '/templates');
    $template = $factory->open('ServerForm.php');
    /* The PluginEngine must be used here. 
       If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */
    $template->set_attribute('action', PluginEngine::getLink('MumieTask', array('server_id' => $server["server_id"]), 'admin/addServer'));
    echo $template->render();
?>

