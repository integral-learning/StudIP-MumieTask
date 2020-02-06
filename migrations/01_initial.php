<?php 
class Initial extends Migration {
    public function up() {
        $db = DBManager::get();

        $db->exec("CREATE TABLE IF NOT EXISTS mumie_server (
            server_id integer NOT NULL AUTO_INCREMENT,
            name text NOT NULL,
            url_prefix text NOT NULL,
            PRIMARY KEY (server_id)
            );"
        );

        /*
        $db->exec("CREATE TABLE IF NOT EXISTS mumie_task (
            task_id integer NOT NULL AUTO_INCREMENT,
            name text NOT NULL,
            course integer NOT NULL,
            task_url text NOT NULL,
            launch_container integer NOT NULL,
            mumie_course text NOT NULL,
            language text NOT NULL,
            server text NOT NULL,
            mumie_coursefile text NOT NULL,
            points integer NOT NULL,
            duedate integer,
            privategradepool integer NOT NULL,
            PRIMARY KEY (task_id)
            );"
        );*/
        $db->exec("CREATE TABLE IF NOT EXISTS mumie_task (
            task_id integer NOT NULL AUTO_INCREMENT,
            name text NOT NULL,
            course integer NOT NULL,
            task_url text NOT NULL,
            launch_container integer NOT NULL,
            mumie_course text NOT NULL,
            language text NOT NULL,
            server text NOT NULL,
            PRIMARY KEY (task_id)
            );"
        );

        $db->exec("INSERT INTO mumie_server (name, url_prefix)
            VALUES
            ('OMB+', 'https://www.ombplus.de/ombplus/')
            ;");

        Config::get()->create("MUMIE_SHARE_FIRSTNAME", array(
            'value'       => "asdasd",
            'is_default'  => 0,
            'type'        => 'boolean',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'Vornamen der User mit MUMIE-Servern teilen'
        ));
        Config::get()->create("MUMIE_SHARE_LASTNAME", array(
            'value'       => "asdasd",
            'is_default'  => 0,
            'type'        => 'boolean',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'Nachnamen der User mit MUMIE-Servern teilen'
        ));
        Config::get()->create("MUMIE_SHARE_EMAIL", array(
            'value'       => "asdasd",
            'is_default'  => 0,
            'type'        => 'boolean',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'E-Mail der User mit MUMIE-Servern teilen'
        ));
        Config::get()->create("MUMIE_ORG", array(
            'value'       => "asdasd",
            'type'        => 'string',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'Geben Sie ihr Org-Merkmal an'
        ));
        Config::get()->create("MUMIE_API_KEY", array(
            'value'       => "asdasd",
            'type'        => 'string',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'Geben Sie ihren API-Key an'
        ));
    }

    public function down() {
        $db = DBManager::get();
        $db->exec("DROP TABLE mumie_server;");
        $db->exec("DROP TABLE mumie_task");

        Config::get()->delete("MUMIE_SHARE_FIRSTNAME");
        Config::get()->delete("MUMIE_SHARE_LASTNAME");
        Config::get()->delete("MUMIE_SHARE_EMAIL");
        Config::get()->delete("MUMIE_ORG");
        Config::get()->delete("MUMIE_API_KEY");
    }
}