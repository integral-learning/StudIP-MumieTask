<?php 

require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/SSOService.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/MumieSSOToken.php');
class SystemController extends StudipController {

    function verifyToken_action() {
        $token = $_POST['token'];
        $user = $_POST['userId'];
        echo json_encode(SSOService::verifyToken($token, $user));
        exit;
    }
}
