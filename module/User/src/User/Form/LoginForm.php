<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Form\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginForm
 * Форма логина пользователя
 * @author kopychev
 */
class LoginForm extends MyAbstractForm {

    public function __construct() {
        parent::__construct();
        $this->setName('login');
        $this->setAttribute('method', 'post');

        $this->setAttribute('id', 'login-form');
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'size' => 30,
                'id' => 'login',
                'placeholder' => 'Логин пользователя...',
            ),
            'options' => array(
                'label' => 'Логин пользователя ',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
                'size' => 30,
                'id' => 'password',
                'placeholder' => 'Пароль...',
            ),
            'options' => array(
                'label' => 'Пароль ',
                'label_attributes' => array(
                    'class' => 'control-label'
                )
            )
        ));


        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox',
            'attributes' => array(
                "class" => "remember-checkbox",
                "id" => "rememberme"
            ),
            'options' => array(
                'label' => 'Запомнить меня',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Войти',
                'class' => 'btn bg-olive btn-block'
            ),
            'options' => array(
            )
        ));
    }

}
