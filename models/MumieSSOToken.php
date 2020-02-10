<?php

class MumieSSOToken extends SimpleORMap {
    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_sso_tokens';
        parent::configure($config);
    }

    public static function findByUser($user) {
        return MumieSSOToken::findOneBySql("the_user = ?", array($user));
    }
}