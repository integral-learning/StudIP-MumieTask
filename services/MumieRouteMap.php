<?php

class MumieRouteMap extends \RESTAPI\RouteMap {

    public function before() {

    }

    /**
     * Verify a login token sent to a MUMIE server
     * @get /verifyToken
     */
    public function verifyToken() {
        return sprintf("Hello World");
    }

    public function after() {

    }

}