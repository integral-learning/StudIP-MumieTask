<?php

class TaskOptionCollector {

    private $serverOptions;
    private $courseOptions;
    private $taskOptions;
    private $langOptions;
    private $servers;

    function __construct($servers) {
        $this->servers = $servers;
    }


    public function collect() {
        foreach ($this->servers as $server) {
            $this->compileServerOption($server);
            $this->compileLangOptions($server);
        }
    }

    private function compileLangOptions($server)
    {
        foreach ($server->getLanguages() as $lang) {
            $this->langOptions[$lang] = $lang;
        };
    }

    private function compileServerOption($server)
    {
        $this->serverOptions[$server->getUrlprefix()] = $server->getName();
        foreach ($server->getCourses() as $course) {
            $this->compileCourseOption($course);
        }
    }

    private function compileCourseOption($course)
    {
        $this->courseOptions[$course->getName()] = $course->getName();

        foreach ($course->getTasks() as $task) {
            $this->compileTaskOption($task);
        }
    }

    private function compileTaskOption($task)
    {
        $this->taskOptions[$task->getLink()] = $task->getLink();
    }

    /**
     * Get the value of courseOptions
     */ 
    public function getCourseOptions()
    {
        return $this->courseOptions;
    }

    /**
     * Get the value of serverOptions
     */ 
    public function getServerOptions()
    {
        return $this->serverOptions;
    }

    /**
     * Get the value of taskOptions
     */ 
    public function getTaskOptions()
    {
        return $this->taskOptions;
    }

    /**
     * Get the value of langOptions
     */ 
    public function getLangOptions()
    {
        return $this->langOptions;
    }
}