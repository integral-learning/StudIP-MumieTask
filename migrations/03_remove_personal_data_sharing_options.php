<?php

class RemovePersonalDataSharingOptions extends Migration {
    function description()
    {
        return 'Remove the admin option to share firstname/lastname/email with MUMIE servers';
    }

    function up()
    {
        Config::get()->delete('MUMIE_SHARE_FIRSTNAME');
        Config::get()->delete('MUMIE_SHARE_LASTNAME');
        Config::get()->delete('MUMIE_SHARE_EMAIL');
    }

    function down()
    {
        Config::get()->create('MUMIE_SHARE_FIRSTNAME', array(
            'value' => 0,
            'is_default'  => 0,
            'type'        => 'boolean',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'Vornamen der User mit MUMIE-Servern teilen'
        ));
        Config::get()->create('MUMIE_SHARE_LASTNAME', array(
            'value' => 0,
            'is_default'  => 0,
            'type'        => 'boolean',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'Nachnamen der User mit MUMIE-Servern teilen'
        ));
        Config::get()->create('MUMIE_SHARE_EMAIL', array(
            'value' => 0,
            'is_default'  => 0,
            'type'        => 'boolean',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'E-Mail der User mit MUMIE-Servern teilen'
        ));
    }
}
