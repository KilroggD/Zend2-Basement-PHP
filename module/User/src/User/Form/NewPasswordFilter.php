<?php
namespace User\Form;
use Zend\InputFilter\InputFilter;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewPasswordFilter
 *
 * @author kopychev
 */
class NewPasswordFilter extends InputFilter{
    //put your code here
    public function __construct() {
                $this->add(array(
           'name'=>'password',
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
));
    }
}
