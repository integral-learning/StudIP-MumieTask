<?php

/**
 * TaskOptionCollector collects options for the MUMIE Task form's dropdown menus.
 */
class TaskOptionCollector
{
    /**
     * All available server options.
     *
     * @var array
     */
    private $serverOptions;
    /**
     * All available course options.
     *
     * @var array
     */
    private $courseOptions;
    /**
     * All available task options.
     *
     * @var array
     */
    private $taskOptions;
    /**
     * All available language options.
     *
     * @var array
     */
    private $langOptions;
    /**
     * The list of MUMIE servers we want to get options for
     *
     * @var MumieServerInstance[]
     */
    private $servers;
    
    /**
     * __construct
     *
     * @param  MumieServerInstance[] $servers
     * @return void
     */
    public function __construct($servers)
    {
        $this->servers = $servers;
    }

    
    /**
     * Collect all options.
     *
     * @return void
     */
    public function collect()
    {
        foreach ($this->servers as $server) {
            $this->compileServerOption($server);
            $this->compileLangOptions($server);
        }
    }
    
    /**
     * Collect all language options for a given server.
     *
     * Format: array[langcode] = langcode
     *
     * @param  MumieServerInstance $server
     * @return void
     */
    private function compileLangOptions($server)
    {
        foreach ($server->getLanguages() as $lang) {
            $this->langOptions[$lang] = $lang;
        };
    }
    
    /**
     * Add server options and collect its course options.
     *
     * Format: array[url_prefiy] = name
     *
     * @param  MumieServerInstance $server
     * @return void
     */
    private function compileServerOption($server)
    {
        $this->serverOptions[$server->getUrlprefix()] = $server->getName();
        foreach ($server->getCourses() as $course) {
            $this->compileCourseOption($course);
        }
    }
    
    /**
     * Add course option for a given course and collect its Task options.
     *
     * Format: array[name] = name
     *
     * @param  MumieCourse $course
     * @return void
     */
    private function compileCourseOption($course)
    {
        $this->courseOptions[$course->getName()] = $course->getName();

        foreach ($course->getTasks() as $task) {
            $this->compileTaskOption($task);
        }
    }
    
    /**
     * Add Task option.
     *
     * Format: array[link] = link
     *
     * @param  MumieProblem $task
     * @return void
     */
    private function compileTaskOption($task)
    {
        $this->taskOptions[$task->getLink()] = $task->getLink();
    }

    /**
     * Get the value of courseOptions
     *
     * @return array
     */
    public function getCourseOptions()
    {
        return $this->courseOptions;
    }

    /**
     * Get the value of serverOptions
     *
     * @return array
     */
    public function getServerOptions()
    {
        return $this->serverOptions;
    }

    /**
     * Get the value of taskOptions
     *
     * @return array
     */
    public function getTaskOptions()
    {
        return $this->taskOptions;
    }

    /**
     * Get the value of langOptions
     *
     * @return array
     */
    public function getLangOptions()
    {
        return $this->langOptions;
    }
}
