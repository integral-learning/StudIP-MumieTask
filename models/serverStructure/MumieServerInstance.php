<?php
/**
 * This file is part of the MumieTaskPlugin for StudIP.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 3 of
 * the License, or (at your option) any later version.
 *
 * @author      Tobias Goltz <tobias.goltz@integral-learning.de>
 * @copyright   2020 integral-learning GmbH (https://www.integral-learning.de/)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category    Stud.IP
 */

require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieCourse.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieProblem.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieTag.php');
/**
 * Represents a MumieServer in the MUMIE server structure
 */
class MumieServerInstance implements \JsonSerializable
{

    /**
     * Object saved in the database
     *
     * @var MumieServer
     */
    private $server;
    /**
     * This is used as parameter when synchronizing grades
     */
    const MUMIE_GRADE_SYNC_VERSION = 2;

    /**
     * This is used as parameter when requesting available courses and tasks.
     */
    const MUMIE_JSON_FORMAT_VERSION = 3;

    /**
     * Primary key for db entry
     * @var int
     */
    private $id;
    /**
     * Server URL
     * @var string
     */
    private $url_prefix;
    /**
     * A human-readable name for a server configuration
     * @var string
     */
    private $name;

    /**
     * All courses that are available on the server
     * @var mumie_course[]
     */
    private $courses;

    /**
     * All languages that are available on the server
     * @var string[]
     */
    private $languages = array();

    /**
     * Constructor
     *
     * @param  MumieServer $server
     * @return void
     */
    public function __construct($server)
    {
        $this->server = $server;
        $this->name = $server->name;
        $this->url_prefix = $server->url_prefix;
    }

    /**
     * Construct a MumieServerInstance from a given URL
     *
     * @param  string $url
     * @return MumieServerInstance
     */
    public static function fromURL($url)
    {
        $server = new stdClass;
        $server->url_prefix = $url;
        return new MumieServerInstance($server);
    }

    /**
     * Get the latest course structure form the MUMIE server
     * @return stdClass server response
     */
    public function getCoursesAndTasks()
    {
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
    public function isValidMumieServer()
    {
        return $this->getCoursesAndTasks()->courses != null;
    }

    /**
     * Get and set the latest tasks and courses from the MUMIE server
     */
    public function loadStructure()
    {
        $coursesandtasks = $this->getCoursesAndTasks();
        $this->courses = [];
        if ($coursesandtasks) {
            foreach ($coursesandtasks->courses as $course) {
                array_push($this->courses, new MumieCourse($course));
            }
        }
        $this->collectLanguages();
    }

    /**
     * Collect and set a list of all languages that are available on this MUMIE server
     */
    private function collectLanguages()
    {
        $langs = [];
        foreach ($this->courses as $course) {
            array_push($langs, ...$course->getLanguages());
        }
        $this->languages = array_values(array_unique($langs));
    }

    public function getLoginUrl()
    {
        return $this->url_prefix . 'public/xapi/auth/sso/login';
    }

    /**
     * Necessary to encode this object as json.
     * @return mixed
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    /**
     * Get all MUMIE servers from the database and load their structure
     *
     * @return MumieServerIsntance[]
     */
    public static function getAllWithStructure()
    {
        return array_map(function ($server) {
            $instance = new MumieServerInstance($server);
            $instance->loadStructure();
            return $instance;
        }, MumieServer::getAll());
    }

    /**
     * getUrlprefix
     *
     * @return string
     */
    public function getUrlprefix()
    {
        return $this->url_prefix;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get all courses that are available on the server
     *
     * @return  mumie_course[]
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Get all languages that are available on the server
     *
     * @return  string[]
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Find a course in this server by name
     *
     * @param  string $name
     * @return MumieCourse
     */
    public function getCourseByName($name)
    {
        foreach ($this->courses as $course) {
            foreach ($course->getName() as $translation) {
                if ($translation->value == $name) {
                    return $course;
                }
            }
        }
    }

    /**
     * Find a course in this server by course file path
     *
     * @param  string $coursefile
     * @return MumieCourse
     */
    public function getCourseByCoursefile($coursefile)
    {
        foreach ($this->courses as $course) {
            if ($course->getCoursefile() === $coursefile) {
                return $course;
            }
        }
    }

    /**
     * Get the url this server uses for grade synchronization.
     *
     * @return string
     */
    public function getGradeSyncUrl()
    {
        return $this->url_prefix . 'public/xapi?v=' . self::MUMIE_GRADE_SYNC_VERSION;
    }
}
