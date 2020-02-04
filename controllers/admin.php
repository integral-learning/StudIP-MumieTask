<?php 
require_once('app/controllers/plugin_controller.php');

class AdminController extends StudipController {

    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        $navigation = new Navigation('Mumie');
        $navigation->setURL('https://www.google.de');

        $links = new LinksWidget();
        $links->setTitle("Einstellungen");
        $links->addLink(
            dgettext('MumieTask', 'MUMIE-Server'),
            PluginEngine::getURL("MumieTask", array(), 'admin/index'),
            null);
        $links->addLink(
            dgettext('MumieTask', 'Datenschutz'),
            PluginEngine::getURL("MumieTask", array(), 'admin/privacy'),
            null);
        $links->addLink(
            dgettext('MumieTask', 'Authentification'),
            PluginEngine::getURL("MumieTask", array(), 'admin/authentication'),
            null);
        Sidebar::Get()->addWidget($links);
    }

    public function index_action() {
        $this->servers = DBManager::get()->query("SELECT * FROM mumie_server ORDER BY name ASC")->fetchAll();
    }

    public function privacy_action() {
        if(Request::isPost()) {
            $config = Config::get();
            $config->store(MUMIE_SHARE_FIRSTNAME, Request::get('share_firstname'));
            $config->store(MUMIE_SHARE_LASTNAME, Request::get('share_lastname'));
            $config->store(MUMIE_SHARE_EMAIL, Request::get('share_email'));
            PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'Änderungen gespeichert') . '!'));

            //$this->redirect(PluginEngine::getURL("MumieTask", array(), 'admin/index'));
        }

    }
    
    public function addServer_action() {
        if(Request::isPost()) {
            $server = new MumieServer();
            $server['name'] = Request::get('name');
            $server['url_prefix'] = Request::get('url_prefix');
            $server->store();
            PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'Server erfolgreich hinzugefügt') . '!'));
     
            $this->redirect('admin/index');
            
        }
    }

    public function delete_action() {
        $phrase = new MumieServer(Request::option('server_id'));
        $phrase->delete();
        PageLayout::postMessage(
        MessageBox::success(dgettext('MumieServer', 'Server wurde gelöscht') . '!'));
        $this->redirect(PluginEngine::getURL("MumieTask", array(), 'admin/index'));
    }

    public function authentication_action() {
        if(Request::isPost()) {
            $config = Config::get();            
            $config->store(MUMIE_ORG, Request::get('mumie_org'));
            $config->store(MUMIE_API_KEY, Request::get('mumie_api_key'));
            PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'Änderungen gespeichert') . '!'));
            $this->redirect(PluginEngine::getURL("MumieTask", array(), 'admin/index'));
        }
    }
}