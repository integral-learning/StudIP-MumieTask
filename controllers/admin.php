<?php
/**
 * This file is part of the MumieTaskPlugin for StudIP.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 3 of
 * the License, or (at your option) any later version.
 *
 * @author      Tobias Goltz <tobias.goltz@integral-learning.de>
 * @copyright   2020 integral-learning GmbH (https://www.integral-learning.de/)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category    Stud.IP
 */

require_once('app/controllers/plugin_controller.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieServerInstance.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/PermissionService.php');

/**
 * This controller is used to display and edit global settings for MUMIE Tasks on an admin level.
 */
class AdminController extends StudipController
{
        
    /**
     * Execute this before any other action.
     *
     * Check for admin permission, set title and manage navigation.
     *
     * @param  mixed $action
     * @param  mixed $args
     * @return void
     */
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        Navigation::activateItem('/admin/config/mumie');
        PermissionService::requireAdminPermission();
        PageLayout::setTitle(dgettext("MumieTaskPlugin", "MUMIE-Task") . ": " . dgettext("MumieTaskPlugin", "Admininstrator-Einstellungen"));
    }
    
    /**
     * This action is associated with the landing page of admin settings.
     *
     * Load MUMIE server data from the database.
     *
     * @return void
     */
    public function index_action()
    {
        $this->servers = MumieServer::findBySQL("server_id > 0");
    }
    
    /**
     * This function is used to save changes in the privacy settings.
     *
     * @return void
     */
    public function privacy_action()
    {
        if (Request::isPost()) {
            $config = Config::get();
            $config->store(MUMIE_SHARE_FIRSTNAME, Request::get('share_firstname'));
            $config->store(MUMIE_SHARE_LASTNAME, Request::get('share_lastname'));
            $config->store(MUMIE_SHARE_EMAIL, Request::get('share_email'));
            PageLayout::postMessage(MessageBox::success(dgettext('MumieTaskPlugin', 'Änderungen gespeichert') . '!'));
        }
        $this->redirect('admin/index');
    }
        
    /**
     * Display a form for creation of MUMIE server or save it (If called by a post request).
     *
     * @return void
     */
    public function addServer_action()
    {
        if (Request::isPost()) {
            $server = new MumieServer();
            $server->name = trim(Request::get('name'));
            $server->url_prefix = MumieServer::getStandardizedUrl(Request::get('url_prefix'));
            $errors = $this->getFormValidationErrors($server);
        
            if (count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $server->store();
                PageLayout::postMessage(MessageBox::success(dgettext('MumieTaskPlugin', 'Server erfolgreich hinzugefügt') . '!'));
                $this->redirect('admin/index');
            }
        }
    }
    
    /**
     * Display a form to edit an existing server or save changes(if it's called by post request).
     * Server_id is part of the POST request.
     *
     * @return void
     */
    public function editServer_action()
    {
        if (Request::isPost()) {
            $server = MumieServer::find(Request::option('server_id'));
            $server->name = trim(Request::get('name'));
            $server->url_prefix = MumieServer::getStandardizedUrl(Request::get('url_prefix'));
            $errors = $this->getFormValidationErrors($server, true);
        
            if (count($errors)>0) {
                PageLayout::postMessage(MessageBox::error(_('Es sind folgende Fehler aufgetreten:'), $errors));
            } else {
                $server->store();
                PageLayout::postMessage(
                    MessageBox::success(dgettext('MumieTaskPlugin', 'Server erfolgreich geändert') . '!')
                );
         
                $this->redirect('admin/index');
            }
        }
    }
    
    /**
     * Delete a given MUMIE server
     * server_id is part of the POST request.
     * @return void
     */
    public function delete_action()
    {
        $server = MumieServer::find(Request::option('server_id'));
        $server->delete();
        PageLayout::postMessage(
            MessageBox::success(dgettext('MumieTaskPlugin', 'Server wurde gelöscht') . '!')
        );
        $this->redirect(PluginEngine::getURL("MumieTaskPlugin", array(), 'admin/index'));
    }
    
    /**
     * Saves changes to the authentification settings (must be called by POST)
     *
     * @return void
     */
    public function authentication_action()
    {
        if (Request::isPost()) {
            $config = Config::get();
            $config->store(MUMIE_ORG, Request::get('mumie_org'));
            $config->store(MUMIE_API_KEY, Request::get('mumie_api_key'));
            PageLayout::postMessage(MessageBox::success(dgettext('MumieTaskPlugin', 'Änderungen gespeichert') . '!'));
        }
        $this->redirect('admin/index');
    }
    
    /**
     * Validate submitted form parameters.
     *
     * @param  MumieServer $server
     * @param  boolean $isEdit
     * @return string[] List of errors.
     */
    private function getFormValidationErrors($server, $isEdit = false)
    {
        $serverInstance = new MumieServerInstance($server);
        $errors = array();

        $serverByPrefix = MumieServer::getByUrl($server->url_prefix);
        $serverByName = MumieServer::getByName($server->name);

        if (!$serverInstance->isValidMumieServer()) {
            $errors[] = dgettext('MumieTaskPlugin', 'Für folgende URL existiert kein MUMIE-Server') . ': <br>' . $server->url_prefix;
        }
        
        if ($isEdit) {
            if ($serverByPrefix != null && $serverByPrefix->id !=$server->id) {
                $errors[] = dgettext('MumieTaskPlugin', 'Es gibt bereits eine Serverkonfiguration für diesen URL-Prefix') . ':<br><br>' . $server->url_prefix;
            }
            if ($serverByName != null && $serverByName->id != $server->id) {
                $errors[] = dgettext('MumieTaskPlugin', 'Es gibt bereits eine Serverkonfiguration für diesen Namen') . '!';
            }
        } else {
            if ($serverByPrefix != null) {
                $errors[] = dgettext('MumieTaskPlugin', 'Es gibt bereits eine Serverkonfiguration für diesen URL-Prefix') . ':<br><br>' . $server->url_prefix;
            }
            if ($serverByName != null) {
                $errors[] = dgettext('MumieTaskPlugin', 'Es gibt bereits eine Serverkonfiguration für diesen Namen') . '!';
            }
        }
        return $errors;
    }
}
