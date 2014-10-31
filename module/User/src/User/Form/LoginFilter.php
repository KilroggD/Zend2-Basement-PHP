<?php

namespace User\Form;

use Zend\InputFilter\InputFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginFilter
 * Сервер-сайд валидаторы для логина пользователя
 * @author kopychev
 */
class LoginFilter extends InputFilter {

    //put your code here
    public function __construct() {

        $this->add(array(
            'name' => 'login',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true));
    }

}
