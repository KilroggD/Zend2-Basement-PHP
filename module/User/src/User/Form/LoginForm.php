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
class LoginForm extends MyAbstractForm{
      public function __construct() {
        parent::__construct();
        $this->setName('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal modal-form');
        $this->setAttribute('id', 'login-form');
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'size'=>30,
                'id'=>'login'
                           ),
            'options'=>array(
                'label'=>'Логин пользователя:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));
 
        $this->add(array(
            'name' => 'password',
            'attributes'=>array(
              'type' => 'password',
              'class'=>'medium-input form-control',
               'size'=>30,
                'id'=>'password'               
            ),
            'options' => array(
               'label'=>'Пароль',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));
         
   
                  $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox',
            'attributes' => array(
            ),
                    'options' => array(
                     'label' => 'Запомнить',
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
                'class'=>'btn btn-primary submit-enter'
            ),
                'options'=>array(
                  
                )
        ));
    }
}
