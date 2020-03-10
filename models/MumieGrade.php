<?php

/**
 * MumieGrade is a single grade for a MUMIE Task awared to a student
 */
class MumieGrade extends SimpleORMap
{
    /**
     * configure
     *
     * @param  mixed $config
     * @return void
     */
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_grades';
        parent::configure($config);
    }
    
    /**
     * Get a students grade for a given MUMIE task.
     *
     * @param  string $taskId
     * @param  string $userId
     * @return MumieGrade
     */
    public static function getGradeForUser($taskId, $userId)
    {
        return self::findOneBySQL("task_id = ? AND the_user = ?", array($taskId, $userId));
    }
    
    /**
     * Get grades for a given task of all students. Also include their names in the data set.
     *
     * @param  string $taskId
     * @return stdClass[]
     */
    public static function getAllGradesForTaskWithRealNames($taskId)
    {
        $query = "SELECT Vorname, Nachname, points 
        FROM mumie_grades JOIN auth_user_md5 on (mumie_grades.the_user = auth_user_md5.user_id) 
        WHERE mumie_grades.task_id = ?  
        ORDER BY Nachname, Vorname";
        return DBManager::get()->fetchAll($query, array($taskId));
    }
}
