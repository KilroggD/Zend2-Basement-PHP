<?php

namespace Organization\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchForm
 *
 * @author kopychev
 */
class SearchForm extends Form {

    public function __construct() {
        parent::__construct();
        $this->setAttribute("class", "admin-form form-horizontal empty-filter");
        $this->setAttribute("id", "search-form");
        $this->setAttribute("method", "GET");
        $this->add(
                array(
                    "name" => "sortby",
                    "type" => "hidden",
                )
        );
        $this->add(
                array(
                    "name" => "sortorder",
                    "type" => "hidden",
                )
        );
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 140,
                'id' => 'name'
            ),
            'options' => array(
                'label' => 'Наименование:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));

        $this->add(array(
            'name' => 'inn',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 12,
                'id' => 'inn'
            ),
            'options' => array(
                'label' => 'ИНН:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));

        $this->add(array(
            "name" => "submit",
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-default',
                'value' => "Найти"
            ),
        ));
    }

}
