<?php 
class MumieHash extends SimpleORMap {
    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_id_hashes';
        parent::configure($config);
    }

    public static function findByHash($hash) {
        return MumieHash::findOneBySQL("hash = ?", array($hash));
    }

    public static function findByUser($userId) {
        return MumieHash::findOneBySQL("the_user = ?", array($userId));
    }
}