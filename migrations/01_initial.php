<?php 
class Initial extends Migration {
    public function up() {
        $db = DBManager::get();

        $db->exec("CREATE TABLE IF NOT EXISTS mumie_servers (
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
        $db->exec("CREATE TABLE IF NOT EXISTS mumie_tasks (
            task_id integer NOT NULL AUTO_INCREMENT,
            name text NOT NULL,
            course integer NOT NULL,
            task_url text NOT NULL,
            launch_container integer NOT NULL,
            mumie_course text NOT NULL,
            language text NOT NULL,
            server text NOT NULL,
            mumie_coursefile text NOT NULL,
            PRIMARY KEY (task_id)
            );"
        );

        $db->exec("CREATE TABLE IF NOT EXISTS mumie_sso_tokens (
            token_id integer NOT NULL AUTO_INCREMENT,
            token text NOT NULL,
            the_user text NOT NULL,
            timecreated integer NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (task_id)
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS mumie_id_hashes (
            hash_id integer NOT NULL AUTO_INCREMENT,
            the_user text NOT NULL,
            hash text NOT NULL,
        )");

        $db->exec("INSERT INTO mumie_servers (name, url_prefix)
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
        $db->exec("DROP TABLE mumie_servers;");
        $db->exec("DROP TABLE mumie_tasks");
        $db->exec("DROP TABLE mumie_sso_tokens");
        $db->exec("DROP TABLE mumie_id_hashes");

        Config::get()->delete("MUMIE_SHARE_FIRSTNAME");
        Config::get()->delete("MUMIE_SHARE_LASTNAME");
        Config::get()->delete("MUMIE_SHARE_EMAIL");
        Config::get()->delete("MUMIE_ORG");
        Config::get()->delete("MUMIE_API_KEY");
    }
}