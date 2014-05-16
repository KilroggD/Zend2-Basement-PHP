<?php
namespace User\Form;
use Acl\Entity\AclRoles;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleFieldset
 * Филдсет для назначения ролей
 * @author kopychev
 */
class RoleFieldset extends Fieldset implements InputFilterProviderInterface{
    //put your code here
        public function __construct($em,$name = null, $options = array()) {
            parent::__construct('role');
          $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em))->setObject(new AclRoles());
            $this->add(
    array(
        'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
        'name' => 'role',
        'options' => array(
            'object_manager'     => $em,
            'target_class'       => 'Acl\Entity\AclRoles',
            'property'           => 'name',            
                      'is_method'      => true,
            'find_method'    => array(
                'name'   => 'findBy',
                'params' => array(
                    'criteria' => array('builtIn' => 0),
                    'orderBy'  => array('name' => 'ASC'),
                ),
                ),
        ),
    )
);
        }

                public function getInputFilterSpecification() {
return array(
  'role'=>array(
      'required'=>false,
  ),

);
    }
        
    
}
