<?php
namespace User\Form;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileForm
 *
 * @author kopychev
 */
class ProfileForm extends AbstractForm{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
          $this->setName('profile');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal built-in-form');
        $this->setAttribute('role', 'form');    
        $this->setAttribute('id', 'profile-form'); 
               $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
             'id'=>'email',
                'size'=>50,
                'maxlength'=>64,
                           ),
            'options'=>array(
                'label'=>'E-mail*:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));
        $this->add(array(
            'name' => 'firstName',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
           'id'=>'firstname',
                'size'=>50,
                'maxlength'=>64,
                           ),
            'options'=>array(
                'label'=>'Имя:',
                'label_attributes'=>array(
                    'class'=>'col-md-4 control-label',
                )
            )
        ));
         $this->add(array(
            'name' => 'lastName',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'id'=>'lastname',
                'size'=>50,
                'maxlength'=>64,
                           ),
            'options'=>array(
                'label'=>'Фамилия:',
                'label_attributes'=>array(
                    'class'=>'col-md-4 control-label',
                )
            )
        ));
         $this->add(array(
            'name' => 'middleName',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'id'=>'middlename',
                'size'=>50,
                'maxlength'=>64,
                           ),
            'options'=>array(
                'label'=>'Отчество:',
                'label_attributes'=>array(
                    'class'=>'col-md-4 control-label',
                )
            )
        ));
         $this->add(array(
            'name' => 'occupation',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'id'=>'occupation',
                'size'=>50,
                'maxlength'=>64,
                           ),
            'options'=>array(
                'label'=>'Должность:',
                'label_attributes'=>array(
                    'class'=>'col-md-4 control-label',
                )
            )
        ));
                  $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'id'=>'phone',
                'size'=>50,
                'maxlength'=>64,
                           ),
            'options'=>array(
                'label'=>'Телефон:',
                'label_attributes'=>array(
                    'class'=>'col-md-4 control-label',
                )
            )
        ));
                        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'class'=>'btn btn-primary submit-enter'
            ),
                'options'=>array(
                  
                )
        ));
    }
}
