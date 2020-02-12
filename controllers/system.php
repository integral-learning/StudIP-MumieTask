<?php 
class SystemController extends StudipController {

    function verifyToken_action() {
        $response = new stdClass();
        $response->status = "valid";
        $response->token = $_POST['token'];
        echo json_encode($response);
        exit;
    }
}
