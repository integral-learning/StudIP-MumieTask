<?php
require_once('HashingService.php');
class SSOService
{
    const TOKEN_LENGTH = 30;

    public static function generateTokenForUser($userId)
    {
        $hashedUserID = HashingService::getHash($userId)->hash;
        if ($ssoToken = MumieSSOToken::findByUser($hashedUserID)) {
        } else {
            $ssoToken = new MumieSSOToken();
            $ssoToken->the_user = $hashedUserID;
        }
        $ssoToken->token = self::generateToken();
        $ssoToken->timecreated = time();
        $ssoToken->store();
        return $ssoToken;
    }

    private static function generateToken()
    {
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

    public static function verifyToken($token, $hashedId)
    {
        $response = new stdClass();
        $studipUserId = HashingService::getUserIdFromHash($hashedId);
        $mumieToken = MumieSSOToken::findOneBySql("the_user = ? AND token = ?", array($hashedId, $token));
        $db = DBManager::get();
        $userRecord = $db->query(
            'SELECT user_id, Vorname, Nachname, Email FROM auth_user_md5, mumie_id_hashes WHERE user_id = mumie_id_hashes.the_user AND mumie_id_hashes.hash = ' . $db->quote($hashedId)
        )->fetchOne();

        if (!is_null($mumieToken) && $mumieToken->token == $token && $userRecord != null) {
            $current = time();
            if (($current - $mumieToken->timecreated) >= (60*60)) {
                $response->status = "invalid";
            } else {
                $response->status = "valid";
                $response->userid = $hashedId;

                if (Config::get()->MUMIE_SHARE_FIRSTNAME) {
                    $response->firstname = $userRecord['Vorname'];
                }
                if (Config::get()->MUMIE_SHARE_LASTNAME) {
                    $response->lastname = $userRecord['Nachname'];
                }
                if (Config::get()->MUMIE_SHARE_EMAIL) {
                    $response->email = $userRecord['Email'];
                }
            }
        } else {
            $response->status = "invalid";
        }
        return $response;
    }
}
