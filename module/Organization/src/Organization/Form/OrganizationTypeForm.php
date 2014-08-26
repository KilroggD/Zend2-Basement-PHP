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
 * Description of OrganizationTypeForm
 *
 * @author kopychev
 */
class OrganizationTypeForm extends Form{
    //put your code here
    public function __construct() {
               $this->setAttribute("class", "admin-form");
     $this->setAttribute("id","org-type-form");
    $this->setAttribute("method","POST");
        parent::__construct();
        $this->setAttribute("class", "form-inline organization-type-form");
        $this->setAttribute("id","add-organization-type-form");
        $this->setAttribute("method","POST");
        $this->setAttribute("role","form");
        $this->add(array(
           'name'=>'name',
            'attributes'=>array(
                "id"=>"name",
                "class"=>"medium-input form-control col-md-4",
                "placeholder"=>"Наименование типа",
                "type"=>"text"            
            )
        ));
                    $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить',
                'class'=>'btn submit btn-default'
            ),
                     ));
    }
    
}
