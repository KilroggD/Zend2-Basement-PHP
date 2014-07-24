<?php
namespace Log\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/** @ODM\Document(collection="log") */
class Log
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $importance;
    
    /** @ODM\Field(type="string") */
    private $category;
    
    /** @ODM\Field(type="string") */
    private $text;

    private $timestamp;
    public function __construct() {
        $this->timestamp=time();
    }
    /**
     * @return the $id
     */          
        public function getId() {
        return $this->id;
    }

    /**
     * @return string $importance
     */
    public function getImportance() {
        return $this->importance;
    }
   /**
     * @param string $importance
     */
    public function setImportance($importance) {
        $this->importance = $importance;
    }
    
        /**
     * @return string $category
     */
    public function getCategory() {
        return $this->category;
    }
   /**
     * @param string $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }
    
    
        /**
     * @return string $importance
     */
    public function getText() {
        return $this->text;
    }
   /**
     * @param string $importance
     */
    public function setText($text) {
        $this->text = $text;
    }
    
    /**
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

 

}