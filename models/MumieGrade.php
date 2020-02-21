<?php 
class MumieGrade extends SimpleORMap {
    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_grades';
        parent::configure($config);
    }

    public static function getGradeForUser($taskId, $userId) {
        return self::findOneBySQL("task_id = ? AND the_user = ?", array($taskId, $userId));
    }

    public static function getAllGradesForTaskWithRealNames($taskId) {
        //return self::findBySQL("task_id = ?", array($taskId));
        $query = "SELECT Vorname, Nachname, points 
        FROM mumie_grades JOIN auth_user_md5 on (mumie_grades.the_user = auth_user_md5.user_id) 
        WHERE mumie_grades.task_id = ?  
        ORDER BY Nachname, Vorname";
        return DBManager::get()->fetchAll($query, array($taskId));
    }
}