<?php
class HashingService
{
    public static function getHash($userId)
    {
        if ($hash = MumieHash::findByUser($userId)) {
        } else {
            $hash = new MumieHash();
            $hash->the_user = $userId;
            $hash->hash = self::getHashedUserId($userId);
            $hash->store();
        }
        return $hash;
    }

    private static function getHashedUserId($userId)
    {
        return hash("sha512", $id . substr(Config::get()->MUMIE_API_KEY, 0, 10));
    }

    public static function getUserIdFromHash($hash)
    {
        return MumieHash::findByHash($hash)->the_user;
    }
}
