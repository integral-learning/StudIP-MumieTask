<?php

class MumieCourse implements \JsonSerializable{
    /**
     * The course's name
     * @var string
     */
    private $name;
    /**
     * All tasks available on the server
     * @var mumie_problem[]
     */
    private $tasks;
    /**
     * Identifier of the course
     * @var string
     */
    private $coursefile;
    /**
     * All languages that are available in this course
     * @var string[]
     */
    private $languages = array();
    /**
     * All tags set for tasks in this course
     * @var mumie_tag[]
     */
    private $tags = array();

    /**
     * Get the value of coursefile
     * @return string
     */

    /**
     * Constructor
     * @param stdClass $coursewithtasks
     */
    public function __construct($coursewithtasks) {
        $this->name = $coursewithtasks->name;
        $this->coursefile = $coursewithtasks->pathToCourseFile;
        $this->tasks = [];
        if ($coursewithtasks->tasks) {
            foreach ($coursewithtasks->tasks as $task) {
                $taskobj = new MumieProblem($task);
                array_push($this->tasks, $taskobj);
            }
        }
        $this->collectLanguages();
        $this->collectTags();
    }

    /**
     * Collect and set all languages used in this course
     */
    public function collectLanguages() {
        $langs = [];
        foreach ($this->tasks as $task) {
            array_push($langs, ...$task->getLanguages());
        }
        $this->languages = array_values(array_unique($langs));
    }

    /**
     * Collect and set all tags that are used in this course
     */
    public function collectTags() {
        $tags = array();
        foreach ($this->tasks as $task) {
            foreach ($task->getTags() as $tag) {
                if (!isset($tags[$tag->getName()])) {
                    $tags[$tag->getName()] = array();
                }
                $tags[$tag->getName()] = $tag->merge($tags[$tag->getName()]);
            }
        }

        $this->tags = array_values($tags);
    }

    /**
     * Necessary to encode this object as json.
     * @return mixed
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }

    public function getLanguages() {
        return $this->languages;
    }
}