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
 * MumieTags are used to store meta information about a MumieProblem. E.G. Chapter, type ect.
 */
class MumieTag implements \JsonSerializable
{
    /**
     * Name of the tag
     * @var string
     */
    private $name;
    /**
     * All values for the tag
     * @var string[]
     */
    private $values = array();

    /**
     * Constructor
     * @param string $name
     * @param string[] $values
     */
    public function __construct($name, $values)
    {
        $this->name = $name;
        $this->values = $values;
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
     * Merge this tag with another into a new one
     * @param MumieTag $tag the tag to merge with
     * @return MumieTag the new tag
     */
    public function merge($tag)
    {
        $mergedtag = new MumieTag($this->name, $this->values);
        if ($tag instanceof MumieTag && $tag->name == $mergedtag->name) {
            array_push($mergedtag->values, ...$tag->values);
            $mergedtag->values = array_values(array_unique($mergedtag->values));
        }

        return $mergedtag;
    }

    /**
     * Get the name of this tag
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
