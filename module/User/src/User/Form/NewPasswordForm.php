<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Form\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewPasswordForm extends MyAbstractForm {

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->setAttribute("name", "new-password-form");
        $this->setAttribute("id", "new-password-form");
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'userid',
                'size' => 50,
                'maxlength' => 64,
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'medium-input form-control',
                'id' => 'userpassword',
                'size' => 50,
                'maxlength' => 64,
            ),
            'options' => array(
                'label' => 'Пароль*:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));
        $this->add(array(
            'name' => 'confirmpassword',
            'attributes' => array(
                'type' => 'password',
                'class' => 'medium-input form-control',
                'id' => 'confirmpassword',
                'size' => 50,
                'maxlength' => 64,
            ),
            'options' => array(
                'label' => 'Подтверждение пароля*:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-default',
                'value' => 'Изменить пароль',
            ),
        ));
    }

}
