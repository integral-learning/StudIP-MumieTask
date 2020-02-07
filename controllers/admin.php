<?php 
require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');

// TODO: Make sure that only admins have access

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
        $this->servers = MumieServer::findBySQL("server_id > 0");
    }

    public function privacy_action() {
        if(Request::isPost()) {
            $config = Config::get();
            $config->store(MUMIE_SHARE_FIRSTNAME, Request::get('share_firstname'));
            $config->store(MUMIE_SHARE_LASTNAME, Request::get('share_lastname'));
            $config->store(MUMIE_SHARE_EMAIL, Request::get('share_email'));
            PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'Änderungen gespeichert') . '!'));
        }
    }
    
    public function addServer_action() {
        if(Request::isPost()) {
            $server = new MumieServer();
            $server->name = trim(Request::get('name'));
            $server->url_prefix = MumieServer::getStandardizedUrl(Request::get('url_prefix'));
            $errors = $this->getFormValidationErrors($server);
        
            if(count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $server->store();
                PageLayout::postMessage(MessageBox::success(dgettext('MumieTask', 'Server erfolgreich hinzugefügt') . '!'));
                $this->redirect('admin/index');
            }
            
        }
    }

    public function editServer_action() {
        if(Request::isPost()) {
            $server = MumieServer::find(Request::option('server_id'));
            $server->name = trim(Request::get('name'));
            $server->url_prefix = MumieServer::getStandardizedUrl(Request::get('url_prefix'));
            $errors = $this->getFormValidationErrors($server, true);
        
            if(count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $server->store();
                PageLayout::postMessage(
                    MessageBox::success(dgettext('MumieTask', 'Server erfolgreich geändert') . '!')
                );
         
                $this->redirect('admin/index');
            }    
        }
    }

    public function delete_action() {
        $server = MumieServer::find(Request::option('server_id'));
        $server->delete();
        PageLayout::postMessage(
            MessageBox::success(dgettext('MumieServer', 'Server wurde gelöscht') . '!')
        );
        $this->redirect(PluginEngine::getURL("MumieTaskPlugin", array(), 'admin/index'));
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

    private function getFormValidationErrors($server, $isEdit = false) {
        $serverInstance = new MumieServerInstance($server);
        $errors = array();

        $serverByPrefix = MumieServer::getByUrl($server->url_prefix);
        $serverByName = MumieServer::getByName($server->name);

        if(!$serverInstance->isValidMumieServer()) {
            $errors[] = dgettext('MumieTask', 'Für folgende URL existiert kein MUMIE-Server') . ': <br>' . $server->url_prefix;
        }
        
        if($isEdit) {
            if($serverByPrefix != null && $serverByPrefix->id !=$server->id) {
                $errors[] = dgettext('MumieTask', 'Es gibt bereits eine Serverkonfiguration für diesen URL-Prefix') . ':<br><br>' . $server->url_prefix;
            }
            if($serverByName != null && $serverByName->id != $server->id) {
                $errors[] = dgettext('MumieTask', 'Es gibt bereits eine Serverkonfiguration für diesen Namen') . '!';
            }
        } else {
            if($serverByPrefix != null) {
                $errors[] = dgettext('MumieTask', 'Es gibt bereits eine Serverkonfiguration für diesen URL-Prefix') . ':<br><br>' . $server->url_prefix;
            }
            if($serverByName != null) {
                $errors[] = dgettext('MumieTask', 'Es gibt bereits eine Serverkonfiguration für diesen Namen') . '!';
            }
        }
        return $errors;
    }
}