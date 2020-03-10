<?php
    PageLayout::setTitle(dgettext("MumieTaskPlugin", "MUMIE-Server bearbeiten"));
    $server = MumieServer::find(Request::option('server_id'));
    $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('ServerForm.php');
    $template->set_attribute('name', $server->name);
    $template->set_attribute('url_prefix', $server->url_prefix);
    /* The PluginEngine must be used here.
       If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */
    $template->set_attribute(
        'action',
        PluginEngine::getLink(
            'MumieTaskPlugin',
            array(
                'server_id' => $server["server_id"]
            ),
            'admin/editServer'
        )
    );
    echo $template->render();
?>

