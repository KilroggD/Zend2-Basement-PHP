<?php
namespace User\Form;
use User\Entity\Users;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserFieldSet
 *
 * @author kopychev
 */
class UserFieldset extends Fieldset 
implements InputFilterProviderInterface
{
    protected $em;
    protected $ifSpec=array(
  'email'=>array(
      'required'=>true,
             'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options'=>array(
                        'messages'=>array(
'emailAddressInvalidFormat' => "E-mail имеет недопустимый формат",
"emailAddressInvalidHostname"=>"Недопустимое доменное имя для Email",
"hostnameUnknownTld"=>"Недопустимое доменное имя для Email",
"hostnameLocalNameNotAllowed"=>"Недопустимое доменное имя для Email"                           
                        )
                    )
                              ),
                    array(
                    'name' => 'NotEmpty',
                    'options'=>array(
                        'messages'=>array(
     'isEmpty' => "Поле обязательно для заполнения",
                        )
                    )
                              ),
                                       ),
  ),
    'login'=>array(
      'required'=>true,
           ),
      'roles'=>array(
      'required'=>false,
  ),
    'password'=>array(
        'required'=>true,        
        'validators'=>array(
                     array(
                    'name' => 'NotEmpty',
                    'options'=>array(
                    //    'useMxCheck'=>true,
                        'messages'=>array(
     'isEmpty' => "Поле обязательно для заполнения",
                        )
                    )
                              ),
          
        ),
    ),
    'confirmpassword'=>array(
        'required'=>true,
            'validators' => array(
              array(
                    'name' => 'NotEmpty',
                    'options'=>array(
                    //    'useMxCheck'=>true,
                        'messages'=>array(
     'isEmpty' => "Поле обязательно для заполнения",
                        )
                    )
                              ),
        array(
            'name' => 'Identical',
            'options' => array(
                'token' => 'password', // name of first password field
                'messages'=>array('notSame'=>'Пароли не совпадают')
            ),
        ),
    ),
    ),  
        "grp"=>array(
            "required"=>true
        )
);
    //put your code here
    public function __construct($em, $name = null, $options = array()) {
        parent::__construct('user');
        $this->em=$em;
              $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em))
                      ->setObject(new Users());
              $this->setName('user')->setAttribute("method","post")->setAttribute("name", "user");              
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
                'label'=>'E-mail:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));
                   
              $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'size'=>30,
                'id'=>'email'
                           ),
            'options'=>array(
                'label'=>'Логин пользователя:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));  
              
     
                $this->add(array(
            'name' => 'password',
            'attributes'=>array(
              'type' => 'password',
              'class'=>'medium-input form-control',
               'id'=>'password',
                'size'=>50,
                'maxlength'=>64,
            ),
            'options' => array(
               'label'=>'Пароль:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));
         $this->add(array(
            'name' => 'confirmpassword',
            'attributes'=>array(
              'type' => 'password',
              'class'=>'medium-input form-control',
              'id'=>'confirmpassword',
                'size'=>50,
                'maxlength'=>64,
            ),
            'options' => array(
               'label'=>'Подтверждение пароля:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
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
        'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
        'name' => 'roles',
        'options' => array(
                            'label' => 'Роли пользователя',
            'object_manager'     => $this->em,
            'target_class'       => 'Acl\Entity\AclRoles',
            'property'           => 'name',            
                      'is_method'      => true,
            'find_method'    => array(
                'name'   => 'findBy',
                'params' => array(
                    'criteria' => array('hidden' => 0),
                    // Use key 'orderBy' if using ORM
                    'orderBy'  => array('name' => 'ASC'),
                ),
                ),
        ),
    )
);
                                  
                                  
       
    }
    
    public function init(){
                 $this->add(array(
             'type' => 'ProfileFieldset',
             'name' => 'profile',
             'options' => array(
                 'label' => 'Профайл пользователя',
                 'should_create_template' => true,
                 'allow_add' => true,
             ),
         ));
                 
                 
    }
    
        public function getInputFilterSpecification() {
return $this->ifSpec;
    }
    public function addOrgField(){
        $this->add(
                          array(
        'type' => 'DoctrineModule\Form\Element\ObjectSelect',
        'name' => 'grp',
       'required' => false,
        'options' => array(
                            'label' => 'Организация',
            'object_manager'     => $this->em,
            'target_class'       => 'Organization\Entity\Organizations',
            'property'           => 'name',   
                      'is_method'      => true,
            'find_method'    => array(
                'name'   => 'findBy',
                'params' => array(
                    'criteria' => array(),
                    // Use key 'orderBy' if using ORM
                    'orderBy'  => array('name' => 'ASC'),
                ),
                ),
        ),
    )
                         );  
    }
    
}
