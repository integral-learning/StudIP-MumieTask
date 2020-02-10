<?php 
class MumieHash extends SimpleORMap {
    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_id_hashes';
        parent::configure($config);
    }

    public static function findByHash($hash) {
        return MumieHash::findOneBySQL("hash = ?", array($hash));
    }
}