<?php

class MumieServerInstance {
    private $server;
    /**
     * This is used as parameter when requesting available courses and tasks.
     */
    const MUMIE_JSON_FORMAT_VERSION = 2;

    function __construct($server) {
        $this->server = $server;
    }

    /**
     * Get the latest course structure form the MUMIE server
     * @return stdClass server response
     */
    public function getCoursesAndTasks() {
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->server->url_prefix . "public/courses-and-tasks?v=" . self::MUMIE_JSON_FORMAT_VERSION,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    /**
     * Check if this URL actually belongs to a MUMIE server
     * @return bool
     */
    public function isValidMumieServer() {
        return $this->getCoursesAndTasks()->courses != null;
    }
}