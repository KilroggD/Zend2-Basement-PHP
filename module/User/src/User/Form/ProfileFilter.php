<?php
namespace User\Form;
use Zend\InputFilter\InputFilter;
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
            'name' => 'userlogin',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options'=>array(
                        'pattern'=>'/[a-z0-9_\.\-]/i',
                        'messages'=>array(
                       'regexNotMatch'=>'Логин может содержать только цифры, латинские буквы, нижнее подчеркивание, тире, точка'
                        )
                    )
                              ),
                array (
                    'name'=>'StringLength',
                     'options'=>array(
                         'min'=>2,
                          'messages'=>array(
            'stringLengthTooShort' => 'Длина логина не менее двух символов', 
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
            'name' => 'username',
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
            'name' => 'userlastname',
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
        
    }
}
