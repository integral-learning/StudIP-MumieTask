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

/**
 * HashingService generates and looks up hashes for user pseudoymization during SSO to MUMIE servers.
 */
class HashingService
{
    /**
     * The MUMIE server assigns the "Lecturing" role instead of the "Studying"
     * default only if the SSO user id ends with this exact literal suffix.
     */
    const LECTURER_SUFFIX = '@lecturer@';

    /**
     * Get a MumieHash for a user. If no MumieHash is found in the database, create one.
     *
     * @param  string $userId
     * @return MumieHash
     */
    public static function getHash($userId)
    {
        return self::findOrCreate($userId, self::getHashedUserId($userId));
    }

    /**
     * Get the MumieHash with the lecturer suffix for a user. If it's not found in the database, create one.
     *
     * @param  string $userId
     * @return MumieHash
     */
    public static function getLecturerHash($userId)
    {
        return self::findOrCreate($userId, self::getHashedUserId($userId) . self::LECTURER_SUFFIX);
    }

    /**
     * Find the MumieHash for a user and hash value. If none is found, create one.
     *
     * Looking up by hash value as well keeps this correct after the API key was changed.
     *
     * @param  string $userId
     * @param  string $hashValue
     * @return MumieHash
     */
    private static function findOrCreate($userId, $hashValue)
    {
        if ($hash = MumieHash::findOneBySQL("the_user = ? AND hash = ?", [$userId, $hashValue])) {
            return $hash;
        }
        $hash = new MumieHash();
        $hash->the_user = $userId;
        $hash->hash = $hashValue;
        $hash->store();
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
        return hash("sha512", $userId . substr(Config::get()->MUMIE_API_KEY, 0, 10));
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
