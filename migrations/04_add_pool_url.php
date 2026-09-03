<?php

class AddPoolUrl extends Migration {
    function description()
    {
        return 'Add a configurable URL for the MUMIE pool/LMS-problem-selector';
    }

    function up()
    {
        Config::get()->create('MUMIE_POOL_URL', array(
            'value' => 'https://pool.mumie.net',
            'type'        => 'string',
            'range'       => 'global',
            'section'     => 'global',
            'description' => 'URL des MUMIE-Pool-Servers, der zur Aufgabenauswahl genutzt wird'
        ));
    }

    function down()
    {
        Config::get()->delete('MUMIE_POOL_URL');
    }
}
