<?php
namespace User\Form;
use Zend\Form\Form;
use Zend\Form\Element;
 use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserForm
 * Форма для редактирования юзера админом
 * @author kopychev
 */
class UserForm extends MyAbstractForm{
    //put your code here
    public function __construct($em,$name = null, $options = array()) {
        parent::__construct('user-form');
          $this->setAttribute('method', 'post');
           

    }
    
    public function init(){
                   $this->add(array(
                       'name'=>'user',
             'type' => 'UserFieldset',
             'options' => array(
                 'use_as_base_fieldset' => true,
             ),
         ));        

         $this->add(array(
             'name' => 'submit',
             'attributes' => array(
                 'type' => 'submit',
                 'value' => 'Сохранить',
             ),
         ));
    }
  
}
