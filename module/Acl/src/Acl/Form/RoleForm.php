<?php

namespace Acl\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Форма для создания новой роли
 *
 * @author kopychev
 */
class RoleForm extends Form {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->setAttribute("class", "form-inline role-form");
        $this->setAttribute("id", "add-role-form");
        $this->setAttribute("method", "POST");
        $this->setAttribute("role", "form");
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                "id" => "rolename",
                "class" => "medium-input form-control col-md-4",
                "placeholder" => "Добавить роль",
                "type" => "text"
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить',
                'class' => 'btn submit btn-default'
            ),
        ));
    }

}
