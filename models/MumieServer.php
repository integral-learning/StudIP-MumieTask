<?php

class MumieServer extends SimpleORMap {

    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_servers';
        parent::configure($config);
    }

    public static function getByUrl($url) {
        return self::findOneBySQL("url_prefix = ?", [$url]);
    }

    public static function getByName($name) {
        return self::findOneBySQL("name = ?", [$name]);
    }

    public static function getStandardizedUrl($url) {
        $url = trim($url);
        $url = (substr($url, -1) == '/' ? $url : $url . '/');
        return $url;
    }

    public static function getAll() {
        return self::findBySQL("server_id > 0");
    }

}