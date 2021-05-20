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

/**
 * This class represents a course in the MUMIE server structure.
 */
class MumieCourse implements \JsonSerializable
{
    /**
     * The course's name
     * @var string
     */
    private $name;
    /**
     * All tasks available on the server
     * @var MumieProblem[]
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
     * @var MumieTag[]
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
    public function __construct($coursewithtasks)
    {
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
    public function collectLanguages()
    {
        $langs = [];
        foreach ($this->name as $translation) {
            array_push($langs, $translation->language);
        }
        $this->languages = array_values(array_unique($langs));
    }

    /**
     * Collect and set all tags that are used in this course
     */
    public function collectTags()
    {
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
     * Find a Task in the course structure by a given link
     *
     * @param  string $link
     * @return MumieTask
     */
    public function getTaskByLink($link)
    {
        $link = MumieProblem::removeParamsFromUrl($link);
        foreach ($this->tasks as $task) {
            if ($task->getLink() == $link) {
                return $task;
            }
        }
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
     * Get all languages used in this course.
     *
     * @return string
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Get the name of this course
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get all tasks available on the server
     *
     * @return  MumieProblem[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
