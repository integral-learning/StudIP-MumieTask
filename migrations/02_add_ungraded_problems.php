<?php

class AddUngradedProblems extends Migration {
    function description()
    {
        return 'Add is_graded property to MUMIE Tasks';
    }

    function up()
    {
        $db = DBManager::get();

        $db->query("ALTER TABLE `mumie_tasks` ADD `is_graded` INT NOT NULL DEFAULT 1;");
    }

    function down()
    {
        $db = DBManager::get();
        $db->query("ALTER TABLE `mumie_tasks` DROP COLUMN `is_graded`;");
    }
}
