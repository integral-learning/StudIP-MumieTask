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
 * Representation of MUMIE servers in the database
 */
class MumieServer extends SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_servers';
        parent::configure($config);
    }
    
    /**
     * Find a MumieServer in the database by URL
     *
     * @param  sting $url
     * @return MumieServer
     */
    public static function getByUrl($url)
    {
        return self::findOneBySQL("url_prefix = ?", [$url]);
    }
    
    /**
     * Find a MumieServer in the database by name
     *
     * @param  string $name
     * @return MumieServer
     */
    public static function getByName($name)
    {
        return self::findOneBySQL("name = ?", [$name]);
    }
    
    /**
     * Make sure that the given url ends on '/'
     *
     * @param  string $url
     * @return string
     */
    public static function getStandardizedUrl($url)
    {
        $url = trim($url);
        $url = (substr($url, -1) == '/' ? $url : $url . '/');
        return $url;
    }
    
    /**
     * get all MumieServers saved in the database
     *
     * @return MumieServer[]
     */
    public static function getAll()
    {
        return self::findBySQL("server_id > 0");
    }
}
