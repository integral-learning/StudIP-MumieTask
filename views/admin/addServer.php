<?php

    $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
    $template = $factory->open('ServerForm.php');
    /* The PluginEngine must be used here.
       If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer. I don't know why
    */
    PageLayout::setTitle(dgettext("MumieTaskPlugin", "Neuer MUMIE-Server"));
    $template->set_attribute('name', '');
    $template->set_attribute('url_prefix', '');
    $template->set_attribute(
        'action',
        PluginEngine::getLink(
            'MumieTaskPlugin',
            array(),
            'admin/addServer'
        )
    );
    echo $template->render();
?>

