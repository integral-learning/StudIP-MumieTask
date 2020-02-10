<?php 
class SSOService {
    public static function generateTokenForUser($userId) {
        $hashedUserID = HashingService::getHash($userId);
        if($ssoToken = MumieSSOToken::findByUser($userId)) {

        } else {
            $ssoToken = new MumieSSOToken();
            $ssoToken->the_user = $hashedUserID;
        }
        $ssoToken->token = self::generateToken();
        $ssoToken->timecreated = time();
        $ssoToken->store();
        return $ssoToken;
    }

    private static function generateToken() {
        $token = "";
        $codealphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codealphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codealphabet .= "0123456789";
        $max = strlen($codealphabet) - 1;

        for ($i = 0; $i < self::TOKEN_LENGTH; $i++) {
            $token .= $codealphabet[rand(0, $max)];
        }

        return $token; 
    }

    public static function verifyToken()
    {
        $token = $_POST['token'];
        $hashedID = $_POST['userId'];

        $il_user_id = ilMumieTaskIdHashingService::getUserFromHash($hashed_id);

        $mumietoken = new ilMumieTaskSSOToken($hashed_id);
        $mumietoken->read();

        $user_query = $ilDB->query('SELECT * FROM usr_data WHERE usr_id = ' . $ilDB->quote($il_user_id, "integer"));
        $user_rec = $ilDB->fetchAssoc($user_query);
        $response = new stdClass();
        require_once(__DIR__ . "/class.ilMumieTaskAdminSettings.php");
        $admin_settings = ilMumieTaskAdminSettings::getInstance();

        if (!is_null($mumietoken->getToken()) && $mumietoken->getToken() == $token && $user_rec != null) {
            $current = time();
            if (($current - $mumietoken->getTimecreated()) >= 1000) {
                $response->status = "invalid";
            } else {
                $response->status = "valid";
                $response->userid = $hashed_id;

                if ($admin_settings->getShareFirstName()) {
                    $response->firstname = $user_rec['firstname'];
                }
                if ($admin_settings->getShareLastName()) {
                    $response->lastname = $user_rec['lastname'];
                }
                if ($admin_settings->getShareEmail()) {
                    $response->email = $user_rec['email'];
                }
            }
        } else {
            $response->status = "invalid";
        }
        return $response;
    }
}