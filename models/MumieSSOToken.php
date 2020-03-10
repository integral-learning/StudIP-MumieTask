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
 * MumieSSOToken is used as authentication method for SSO to MUMIE servers
 */
class MumieSSOToken extends SimpleORMap
{
    /**
     * configure
     *
     * @param  mixed $config
     * @return void
     */
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_sso_tokens';
        parent::configure($config);
    }
    
    /**
     * Find a MumieSSOToken by (hashed) user
     *
     * @param  string $user
     * @return MumieSSOToken
     */
    public static function findByUser($user)
    {
        return MumieSSOToken::findOneBySql("the_user = ?", array($user));
    }
    
    /**
     * Find a MumieSSOToken by a token string
     *
     * @param  string $token
     * @return MumieSSOToken
     */
    public static function findByToken($token)
    {
        return MumieSSOToken::findOneBySql("token = ?", array($token));
    }
}
