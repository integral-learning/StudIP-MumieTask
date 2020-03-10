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
 * Some LMS platforms use personal data (e.g. matriculation number) as part of a userId. That's why we need to pseudonymize the id before transmitting them to MUMIE servers.
 */
class MumieHash extends SimpleORMap
{
    /**
     * configure
     *
     * @param  mixed $config
     * @return void
     */
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_id_hashes';
        parent::configure($config);
    }
    
    /**
     * Find a saved MumieHash with a given hash
     *
     * @param  string $hash
     * @return MumieHash
     */
    public static function findByHash($hash)
    {
        return MumieHash::findOneBySQL("hash = ?", array($hash));
    }
    
    /**
     * Find a saved MumieHash by userId
     *
     * @param  string $userId
     * @return MumieHash
     */
    public static function findByUser($userId)
    {
        return MumieHash::findOneBySQL("the_user = ?", array($userId));
    }
}
