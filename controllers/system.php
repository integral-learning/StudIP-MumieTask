<?php

require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
/**
 * This controller provides an endpoint for SSO to MUMIE servers.
 */
class SystemController extends StudipController
{
    /**
     * This function is called as POST by MUMIE servers during single sign on attempts from users to authenticate them.
     *
     * @return void
     */
    public function verifyToken_action()
    {
        $token = $_POST['token'];
        $user = $_POST['userId'];
        echo json_encode(SSOService::verifyToken($token, $user));
        exit;
    }
}
