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
 * Description of GroupForm
 * Форма для групповых операций с юзерами
 * @author kopychev
 */
class GroupForm extends Form{
    //put your code here
       public function __construct($em) {
        parent::__construct();
       $this->setAttribute("class", "admin-form form-horizontal");
       $this->setAttribute("role","list-aggregate");
       $this->setAttribute("data-list","user");
       $this->setAttribute("id","group-operation-form");        
       $this->setAttribute("method","POST");
      $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'actiontype',
             'options' => array(
                     'label' => 'Выполнить действия:',
                     'value_options' => array(
                             'assign' => 'Присвоить роль выбранным',
                             'delete' => 'Удалить выбранных',
                             'block' => 'Заблокировать выбранных',
                             'unblock' => 'Разблокировать выбранных',
                     ),
             ),
            'attributes'=>array(
              "class"=>"group-operation-form-select",
              "id"=>"group-operation-select",
          )
     ));
      
           $this->add(array(
    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
    'name' => 'role',
    'options' => array(
        'object_manager' => $em,
        'target_class'   => '\Acl\Entity\AclRoles',
        'property'       => 'name',
        'is_method'      => true,
        'find_method'    => array(
            'name'   => 'findBy',
            'params' => array(
                 'criteria'=>array('builtIn'=>0),
                 'orderBy'  => array('name' => 'ASC'),
            ),
        ),
    ),
          'attributes'=>array(
              "class"=>"group-operation-form-select",
              "id"=>"assign-role-select",
                       )
       
               
));
  
                        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Применить',
                'class'=>'btn btn-sm btn-primary',
               "id"=>"group-operation-submit"
           )
        ));
           
           
    }
    
}
