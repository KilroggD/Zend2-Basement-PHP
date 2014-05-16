<?php
namespace User\Form;
use User\Entity\UserProfile;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileFieldset
 *
 * @author kopychev
 */
class ProfileFieldset extends Fieldset
implements InputFilterProviderInterface
{
    //put your code here
    public function __construct($em,$name = null, $options = array()) {
   
        parent::__construct('profile');
        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em))->setObject(new UserProfile());
        $this->setLabel('Профиль пользователя'); 
        $this->setName('profile');
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
                  
             
                  
                  
    }
    
  public function getInputFilterSpecification() {
        return array(
            'firstName'=>array(
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
             array(
                    'name' => 'Regex',
                    'options'=>array(
                        'pattern'=>'/[a-zа-яё\-]/i',
                        'messages'=>array(
                       'regexNotMatch'=>'Поле может содержать только русские и латинские буквы, символ "-"'
                        )
                    )
                              ),
          
            ),
        ),
        );
    }
    
}
