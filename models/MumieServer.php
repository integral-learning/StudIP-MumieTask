<?php

class MumieServer extends SimpleORMap {
    static protected function configure($config = array()) {
        $config['db_table'] = 'mumie_server';
        parent::configure($config);
    }
}