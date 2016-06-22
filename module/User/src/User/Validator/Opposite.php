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
class Opposite extends \Zend\Validator\Identical {

    //put your code here
    const NOT_SAME = 'notSame';
    const MISSING_TOKEN = 'missingToken';

    /**
     * Error messages
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_SAME => "The two given tokens do not match",
        self::MISSING_TOKEN => 'No token was provided to match against',
    );

    public function __construct($token = null) {
        parent::__construct($token);
    }

    public function isValid($value, array $context = null) {
        $this->setValue($value);

        $token = $this->getToken();

        if (!$this->getLiteral() && $context !== null) {
            if (is_array($token)) {
                while (is_array($token)) {
                    $key = key($token);
                    if (!isset($context[$key])) {
                        break;
                    }
                    $context = $context[$key];
                    $token = $token[$key];
                }
            }

            // if $token is an array it means the above loop didn't went all the way down to the leaf,
            // so the $token structure doesn't match the $context structure
            if (is_array($token) || !isset($context[$token])) {
                $token = $this->getToken();
            } else {
                $token = $context[$token];
            }
        }

        if ($token === null) {
            $this->error(self::MISSING_TOKEN);
            return false;
        }

        $strict = $this->getStrict();
        if (($strict && ($value === $token)) || (!$strict && ($value !== $token))) {
            $this->error(self::NOT_SAME);
            return false;
        }

        return true;
    }

}
