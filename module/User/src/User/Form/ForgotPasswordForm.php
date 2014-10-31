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
 * Description of ForgotPasswordForm
 *
 * @author kopychev
 */
class ForgotPasswordForm extends MyAbstractForm {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->setName('forgot-password');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal modal-form');
        $this->setAttribute('id', 'forgot-password-form');
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 30,
                'id' => 'email'
            ),
            'options' => array(
                'label' => 'E-mail:',
                'label_attributes' => array(
                    'class' => 'col-sm-8 control-label'
                )
            )
        ));
        $this->setCaptcha();
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-default submit-enter',
                'value' => 'Восстановить пароль',
            ),
                )
        );
    }

}
