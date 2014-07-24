<?php

namespace Log\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Log\Document\Log
 *
 * @ODM\Document(
 *     collection="logs"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Log
{
    /**
     * @var $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $importance
     *
     * @ODM\Field(name="importance", type="string", options={})
     */
    protected $importance;

    /**
     * @var string $category
     *
     * @ODM\Field(name="category", type="string", options={})
     */
    protected $category;
  /**
     * @var string $url
     *
     * @ODM\Field(name="url", type="string", options={})
     */
    protected $url;

    /**
     * @var string $text
     *
     * @ODM\Field(name="text", type="string", options={})
     */
    protected $text;
/**
     * @var string $text
     *
     * @ODM\Field(name="timestamp", type="int", options={})
     */
    protected $timestamp;
    /**
     * Get id
     *
     * @return id $id
     */
    public function __construct() {
        $this->timestamp=time();
    }
    
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set importance
     *
     * @param string $importance
     * @return self
     */
    public function setImportance($importance)
    {
        $this->importance = $importance;
        return $this;
    }

    /**
     * Get importance
     *
     * @return string $importance
     */
    public function getImportance()
    {
        return $this->importance;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }
 /**
     * Set category
     *
     * @param string $category
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Set text
     *
     * @param string $text
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }
}