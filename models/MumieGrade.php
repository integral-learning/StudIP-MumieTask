<?php 
class MumieGrade extends SimpleORMap {
    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_grades';
        parent::configure($config);
    }

    public static function getGradeForUser($gradeId, $userId) {
        return self::findOneBySQL("grade_id = ? AND the_user = ?", array($gradeId, $userId));
    }
}