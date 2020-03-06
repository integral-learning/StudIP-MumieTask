<?php

class MumieTask extends SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_tasks';
        parent::configure($config);
    }

    public static function findAllInCourse($courseId)
    {
        return self::findBySQL("course = ?", array($courseId));
    }
}
