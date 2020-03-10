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
 * A MumieTask represents a single graded exercise in a studip course
 */
class MumieTask extends SimpleORMap
{
    /**
     * configure
     *
     * @param  mixed $config
     * @return void
     */
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_tasks';
        parent::configure($config);
    }
    
    /**
     * Find all MUMIE tasks in a given course
     *
     * @param  string $courseId
     * @return MumieTask[]
     */
    public static function findAllInCourse($courseId)
    {
        return self::findBySQL("course = ?", array($courseId));
    }
}
