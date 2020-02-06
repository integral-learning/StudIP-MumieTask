<?php

class MumieTask extends SimpleORMap {

    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_task';
        parent::configure($config);
    }
}