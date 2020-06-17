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

require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
/**
 * This controller provides an endpoint for SSO to MUMIE servers.
 */
class SystemController extends PluginController
{
    /**
     * This function is called as POST by MUMIE servers during single sign on attempts from users to authenticate them.
     *
     * @return void
     */
    public function verifyToken_action()
    {
        $token = Request::get('token');
        $user = Request::get('userId');
        echo json_encode(SSOService::verifyToken($token, $user));
        exit;
    }
}
