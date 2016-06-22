<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistrationForm
 *
 * @author kopychev
 */
class RegistrationForm extends \User\Form\MyAbstractForm {

    //put your code here
    public function __construct($em, $name = null, $options = array()) {
        parent::__construct('registration-form');
        $this->setAttribute('method', 'post');
    }

    public function init() {
        $this->add(array(
            'name' => 'user',
            'type' => 'UserFieldset',
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));
        //убираем из филдсета роль и статус                                      
        $this->get("user")->remove("roles")->remove("status")->remove("grp");
        //переставим лейблы
        $this->get("user")->setLabel("Регстрационные данные")->get("profile")->setLabel("Информация о пользователе");
        $this->add(array(
            'name' => 'agreement',
            'type' => 'checkbox',
            'id' => 'agreement',
            'attributes' => array(
                'value' => 0,
                'class' => 'checkbox',
                'id' => 'agreement'
            ),
            'options' => array(
                'label' => 'Я принимаю',
                'label_attributes' => array(
                    'class' => 'control-label',
                ),
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
        ));
        $this->setCaptcha();
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Зарегистрироваться',
            ),
        ));
    }

}
