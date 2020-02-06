<?php 

require_once(__DIR__ . '/models/MumieServer.php');

class MumieTask extends StudIPPlugin implements SystemPlugin {
    public function __construct() {
        parent::__construct();
        $config = new Navigation('MUMIE-Task Einstellungen',PluginEngine::getLink($this, array(), 'admin'));
        $config->setURL(PluginEngine::getLink($this, array(), 'admin'));
        Navigation::addItem('/admin/config/mumie', $config);
    } 
}