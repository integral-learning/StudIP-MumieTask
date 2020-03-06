<?php
class MumieProblem implements \JsonSerializable
{
    /**
     * Link to the resource on the MUMIE server
     * @var string
     */
    private $link;
    /**
     * Headlines for all available languages
     * @var stdClass[]
     */
    private $headline;
    /**
     * All languages this task is available in
     * @var string[]
     */
    private $languages = array();
    /**
     * All content tags set for this problem
     * @var MumieTag[]
     */
    private $tags = array();

    /**
     * Get headlines for all available languages
     * @return stcClass[]
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set the value of headline
     * @param stdClass[] $headline
     * @return  self
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Constructor
     * @param stdClass $task
     */
    public function __construct($task)
    {
        $this->link = $task->link;
        $this->headline = $task->headline;
        if (isset($task->tags)) {
            foreach ($task->tags as $tag) {
                array_push($this->tags, new MumieTag($tag->name, $tag->values));
            }
        }
        $this->collectLanguages();
    }

    /**
     * Collect and set all languages this problem is available in
     */
    public function collectLanguages()
    {
        if ($this->headline) {
            foreach ($this->headline as $langitem) {
                array_push($this->languages, $langitem->language);
            }
        }
    }
    /**
     * Get the value of link
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    public static function removeParamsFromUrl($url)
    {
        return substr($url, 0, strpos($url, '?'));
    }

    /**
     * Set the value of link
     * @param string $link
     * @return  self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
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
     * Get the value of languages
     * @return string[]
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set the value of languages
     * @param string[] $languages
     * @return  self
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * Get the value of tags
     * @return MumieTag[]
     */
    public function getTags()
    {
        return $this->tags;
    }
}
