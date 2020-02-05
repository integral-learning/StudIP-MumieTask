<?php

class MumieServer extends SimpleORMap {
    protected static function configure($config = array()) {
        $config['db_table'] = 'mumie_server';
        parent::configure($config);
    }

    public static function loadById($id) {
        $record = MumieServer::find($id);
        $record->server_id = $id;
        return MumieServer::buildExisting($record);
    }

}