<?php


require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieCourse.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieProblem.php');
require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/models/serverStructure/MumieTag.php');
class MumieServerInstance implements \JsonSerializable{
    private $server;
    /**
     * This is used as parameter when requesting available courses and tasks.
     */
    const MUMIE_JSON_FORMAT_VERSION = 2;

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

    function __construct($server) {
        $this->server = $server;
        $this->name = $server->name;
        $this->url_prefix = $server->url_prefix;
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

    /**
     * Get and set the latest tasks and courses from the MUMIE server
     */
    public function loadStructure() {
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
    private function collectLanguages() {
        $langs = [];
        foreach ($this->courses as $course) {
            array_push($langs, ...$course->getLanguages());
        }
        $this->languages = array_values(array_unique($langs));
    }

    /**
     * Necessary to encode this object as json.
     * @return mixed
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }

    public static function getAllWithStructure() {
        return array_map(function($server) {
            $instance = new MumieServerInstance($server);
            $instance->loadStructure();
            return $instance;
        }, MumieServer::getAll());
    }  

    public function getUrlprefix(){
        return $this->url_prefix;
    }

    public function getName() {
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

    public function getCourseByName($name)
    {
        foreach ($this->courses as $course) {
            if ($course->getName() == $name) {
                return $course;
            }
        }
    }
}