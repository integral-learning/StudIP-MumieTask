<?php

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
