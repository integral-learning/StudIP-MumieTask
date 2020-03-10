<?php

/**
 * HashingService generates and looks up hashes for user pseudoymization during SSO to MUMIE servers.
 */
class HashingService
{
    /**
     * Get a MumieHash for a user. If no MumieHash is found in the database, create one.
     *
     * @param  string $userId
     * @return MumieHash
     */
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
    
    /**
     * Salt a given userId, hash it and then return the result
     *
     * @param  string $userId
     * @return string
     */
    private static function getHashedUserId($userId)
    {
        return hash("sha512", $id . substr(Config::get()->MUMIE_API_KEY, 0, 10));
    }
    
    /**
     * Get the real userId linked to a hash
     *
     * @param  string $hash
     * @return string
     */
    public static function getUserIdFromHash($hash)
    {
        return MumieHash::findByHash($hash)->the_user;
    }
}
