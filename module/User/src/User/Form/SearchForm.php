<?php
namespace User\Form;
use Zend\Form\Element;
use Zend\Form\Form;
use \User\Entity\Users;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchForm
 * Форма для поиска юзеров в админке
 * @author kopychev
 */
class SearchForm extends Form{
    //put your code here
        public function __construct($em) {
        parent::__construct();
     $this->setAttribute("class", "admin-form form-horizontal empty-filter");
     $this->setAttribute("id","search-form");
    $this->setAttribute("method","GET");
     $this->add(array(
    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
    'name' => 'role',
    'options' => array(
        'label'=>'Роль:',
        'object_manager' => $em,
        'target_class'   => '\Acl\Entity\AclRoles',
        'property'       => 'name',
        'empty_option'   => 'Выберите роль',
        'is_method'      => true,
        'find_method'    => array(
            'name'   => 'findAll',
            'params' => array(
                 'orderBy'  => array('name' => 'ASC'),
            ),
        ),
    ),
          'attributes'=>array(
              "class"=>"searchform-select",
              "id"=>"role"
          )
));
     $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'status',
             'options' => array(
                     'label' => 'Статус:',
                   'empty_option' => 'Выберите статус',
                     'value_options' => array(
                             Users::INACTIVE => 'Неактивен',
                             Users::ACTIVE => 'Активен',
                             Users::CHANGEPWD => 'Смена пароля',
                             Users::BLOCKED => 'Блокирован',
                     ),
             ),
         'attributes'=>array(
             "id"=>"status"
         )
     ));
     $this->add(
             array(                 
                 "name"=>"sortby",
                 "type"=>"hidden",
             )             
             );
     $this->add(
             array(                 
                 "name"=>"sortorder",
                 "type"=>"hidden",
             )             
             );
                 $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Фильтр',
                'class'=>'btn btn-primary btn-sm',
                "id"=>"search-submit"
            ),
                'options'=>array(
                    'label'=>'',
                    'label_attributes'=>array(
                    )
                )
        ));
        }
}
