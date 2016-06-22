<?php

namespace Install\Form;

use Zend\Form\Element;
use Zend\Form\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Форма для инсталлятора - начальный юзер и прочие параметры
 *
 * @author kopychev
 */
class InstallForm extends Form {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->setName('install');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal modal-form');
        $this->setAttribute('id', 'install-form');
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 30,
                'id' => 'login'
            ),
            'options' => array(
                'label' => 'Логин администратора:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'medium-input form-control',
                'size' => 30,
                'id' => 'password'
            ),
            'options' => array(
                'label' => 'Пароль администратора',
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
                'label' => 'Подтверждение пароля:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));
        $this->add(array(
            'type' => 'radio',
            'name' => 'mongo',
            'options' => array(
                'label' => 'Создать коллекции MongoDB?',
                'value_options' => array(
                    '0' => 'Нет',
                    '1' => 'Да',
                ),
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Установить',
                'class' => 'btn btn-primary submit-enter'
            ),
            'options' => array(
            )
        ));
    }

}
