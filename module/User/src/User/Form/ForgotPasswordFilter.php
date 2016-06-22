<?php

namespace User\Form;

use Zend\InputFilter\InputFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForgotPasswordFilter
 *
 * @author kopychev
 */
class ForgotPasswordFilter extends InputFilter {

    //put your code here
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
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'messages' => array(
                            'emailAddressInvalid' => "E-mail имеет недопустимый формат",
                            'emailAddressDotAtom' => "E-mail имеет недопустимый формат",
                            'emailAddressQuotedString' => "E-mail имеет недопустимый формат",
                            'emailAddressInvalidLocalPart' => "E-mail имеет недопустимый формат"
                        )
                    )
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        //    'useMxCheck'=>true,
                        'messages' => array(
                            'isEmpty' => "Поле обязательно для заполнения",
                        )
                    )
                ),
            ),
        ));
        $this->get('email')->setErrorMessage("Email имеет недопустимый формат");
    }

}
