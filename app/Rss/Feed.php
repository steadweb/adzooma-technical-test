<?php

namespace App\Rss;

use \Iterator;
use \App\Rss\Item as RssItem;

final class Feed implements Iterator
{
    protected $title = null;

    protected $uri = null;

    protected $description = null;

    protected $lastupdated = null;

    protected $items = array();

    private $position = 0;

    public function __construct(string $uri)
    {
        if( !is_string($uri) ) {
            throw new RuntimeException('URI must be a string.');
        }

        $this->uri = $uri;
        $this->parse();
    }

    public function getFeedUri()
    {
        return $this->uri;
    }

    public function getFeedTitle()
    {
        return $this->title;
    }

    public function getFeedDescription()
    {
        return $this->description;
    }

    public function getFeedLastUpdated()
    {
        return $this->lastupdated;
    }

    public function getItems()
    {
        return $this->items;
    }

    private function parse()
    {
        try {
            if($data = simplexml_load_file($this->getFeedUri())) {

                $this->title = (string) $data->channel->title;
                $this->description = (string) $data->channel->description;
                $this->lastupdated = (string) $data->channel->lastBuildDate;
                $this->items = $this->parseItems($data->channel);

                return $this;
            }
        } catch(\Exception $e) {
            throw $e;
        }

        throw new RuntimeException('Unable to parse RSS feed ' . $this->getFeedUri());
    }

    private function parseItems(\SimpleXMLElement $channel)
    {
        $feed_items = [];

        foreach($channel->item as $item) {
            $feed_items[] = new RssItem($item->title, $item->link, strip_tags($item->description), $item->pubDate, $this);
        }

        return $feed_items;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
