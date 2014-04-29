<?php
namespace User\Form;
use Zend\InputFilter\InputFilter;
use User\Validator\Opposite;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileFilter
 *
 * @author kopychev
 */
class ProfileFilter extends InputFilter{
    //put your code here
    public function __construct() {      
           
        
            $this->add(array(
            'name' => 'email',
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options'=>array(
                       'useMxCheck'=>true,
                        'messages'=>array(
'emailAddressInvalidFormat' => "E-mail имеет недопустимый формат",
"emailAddressInvalidHostname"=>"Недопустимое доменное имя для Email",
"hostnameUnknownTld"=>"Недопустимое доменное имя для Email",
"hostnameLocalNameNotAllowed"=>"Недопустимое доменное имя для Email",                           
                        )
                    )
                              ),
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
        ));
        
        $this->add(array(
            'name' => 'firstName',
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
        ));
        
                $this->add(array(
            'name' => 'lastName',
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
        ));
     
                     $this->add(array(
            'name' => 'middleName',
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
        ));
                     
                     $this->add(array(
           'name'=>'password',
               'required'=>false,
                  'validators' => array(
                       array(
                    'name' => 'regex',
                     'options' => array(
                        'pattern' => '/[^а-яё]/ui',
                       'messages'=>array(
                            'regexNotMatch'=>'Пароль может содержать только латинские буквы, цифры и спец-символы'
                        )
        )),
                          array (
                    'name'=>'StringLength',
                     'options'=>array(
                         'min'=>6,
                          'messages'=>array(
            'stringLengthTooShort' => 'Пароль должен состоять не менее чем из 6 символов', 
                          )
                     )
                )
                )
        ));
        $this->add(array(
    'name' => 'confirmpassword', // add second password field
    'validators' => array(
        array(
            'name' => 'Identical',
            'options' => array(
                'token' => 'password', // name of first password field
                'messages'=>array('notSame'=>'Пароли не совпадают')
            ),
        ),
    ),
));
     
                         $this->add(array(
                'name'=>'oldpassword',
               'validators' => array(          
                array(
                    'name'=>'User\Validator\Opposite',
                    'options'=>array(
                        'token'=>'password',
                        'messages'=>array(
                          'notSame'=>"Старый и новый пароли должны отличаться"  
                        ),
                    )
                )
    
                )
        ));
        
    }
}
