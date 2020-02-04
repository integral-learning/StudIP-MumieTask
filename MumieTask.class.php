<?php 

require_once(__DIR__ . '/models/MumieServer.php');

class MumieTask extends StudIPPlugin implements SystemPlugin {
    public function __construct() {
        parent::__construct();
        $url = PluginEngine::getLink($this, array(), 'admin');
        $navigation = new Navigation('MUMIE-Task Einstellungen', $url); //Erzeugen des Navigationselementes mit einem passenden Text und der gewünschten URL
        Navigation::addItem('/start/mumie', $navigation); //ID = eindeutige Bezeichnung des Navigationselementes. /start/ muss auf jeden Fall dorthin, damit das Element auf der Startseite angezeigt wird 
    }
}