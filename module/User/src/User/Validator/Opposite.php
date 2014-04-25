<?php
namespace User\Validator;
use Zend\Validator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opposite
 *
 * @author kopychev
 */
class Opposite extends \Zend\Validator\Identical{
    //put your code here
    const NOT_SAME      = 'notSame';
    const MISSING_TOKEN = 'missingToken';

    /**
     * Error messages
     * @var array
     */
    
    protected $messageTemplates = array(
        self::NOT_SAME      => "The two given tokens do not match",
        self::MISSING_TOKEN => 'No token was provided to match against',
    );
    
    public function __construct($token = null){
        parent::__construct($token);
    }
    
    public function isValid($value, array $context = null) {
        return !parent::isValid($value, $context);
    }
    
}
