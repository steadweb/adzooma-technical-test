<?php

namespace App\Rss;

final class Item
{
    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $uri;

    /**
     * @var
     */
    protected $description;

    /**
     * @var
     */
    protected $published;

    /**
     * @var
     */
    protected $feed;

    /**
     * Create a new Item
     *
     * @param $title
     * @param $uri
     * @param null $description
     * @param null $published
     */
    public function __construct($title, $uri, $description = null, $published = null, $feed = null)
    {
        $this->title = $title;
        $this->uri = $uri;
        $this->description = $description;
        $this->published = $published;
        $this->feed = $feed;

        return $this;
    }

    /**
     * Get the title of the feed item
     *
     * @return mixed
     */
    public function getTitle()
    {
        return (string) $this->title;
    }

    /**
     * Get the URI of the feed item
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the description or provide a default of the feed item
     *
     * @param null $default
     * @return mixed
     */
    public function getDescription($default = null)
    {
        return $this->description;
    }

    /**
     * Get the publish date of the item
     *
     * @param null $format
     * @return mixed
     */
    public function getPublishDate($format = null)
    {
        return $this->published;
    }

    /**
     * Return the feed from where the item came from
     *
     * @return mixed
     */
    public function getFeed()
    {
        return $this->feed;
    }
}
