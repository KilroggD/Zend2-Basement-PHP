<?php

namespace Acl\Form;

use Zend\Form\Element;
use Zend\Form\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclForm
 * Форма для редактирования параметров пермишна
 * @author kopychev
 */
class AclForm extends Form {

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->setAttribute("name", "acl-edit-form");
        $this->setAttribute("id", "acl-edit-form");
        $this->setAttribute("method", "POST");
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'userid',
                'size' => 50,
                'maxlength' => 64,
            ),
        ));
        $this->add(
                array(
                    'name' => 'description',
                    'attributes' => array(
                        'type' => 'text',
                        'class' => 'medium-input form-control',
                        'id' => 'description',
                        'size' => 50,
                        'maxlength' => 64,
                    ),
                    'options' => array(
                        'label' => 'Описание:',
                        'label_attributes' => array(
                            'class' => 'col-md-4 control-label',
                        )
                    )
                )
        );
        $this->add(
                array(
                    'name' => 'controller',
                    'attributes' => array(
                        'type' => 'text',
                        'class' => 'medium-input form-control',
                        'id' => 'controller',
                        'size' => 50,
                        'maxlength' => 64,
                        'readonly' => true,
                    ),
                    'options' => array(
                        'label' => 'Контроллер:',
                        'label_attributes' => array(
                            'class' => 'col-md-4 control-label',
                        )
                    )
                )
        );

        $this->add(
                array(
                    'name' => 'action',
                    'attributes' => array(
                        'type' => 'text',
                        'class' => 'medium-input form-control',
                        'id' => 'action',
                        'size' => 50,
                        'maxlength' => 64,
                        'readonly' => true,
                    ),
                    'options' => array(
                        'label' => 'Действие:',
                        'label_attributes' => array(
                            'class' => 'col-md-4 control-label',
                        )
                    )
                )
        );
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'system',
            'options' => array(
                'label' => 'Системное?',
                'label_attributes' => array(
                    "class" => ''
                ),
                'value_options' => array(
                    '0' => 'Нет',
                    '1' => 'Да',
                ),
            ),
            'attributes' => array(
                "class" => "acl-form-select",
                "id" => "system"
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'exclude',
            'options' => array(
                'label' => 'Исключено из проверки',
                'label_attributes' => array(
                    "class" => ''
                ),
                'value_options' => array(
                    '0' => 'Нет',
                    '1' => 'Да',
                ),
            ),
            'attributes' => array(
                "class" => "acl-form-select",
                "id" => "exclude"
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-default',
                'value' => 'Сохранить',
            ),
        ));
    }

}
