<?php

namespace Organization\Form;

use Zend\InputFilter\InputFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrganizationFilter
 *
 * @author kopychev
 */
class OrganizationFilter extends InputFilter {

    //put your code here
    public function __construct() {
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        //    'useMxCheck'=>true,
                        'messages' => array(
                            'isEmpty' => "Наименование организации не должно быть пустым",
                        )
                    )
                ),
            ),
            "filters" => array(
                array("name" => 'StripTags')
            )
        ));
        $this->add(array(
            'name' => 'shortName',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        //    'useMxCheck'=>true,
                        'messages' => array(
                            'isEmpty' => "Сокращенное наименование не должно быть пустым",
                        )
                    )
                ),
            ),
            "filters" => array(
                array("name" => 'StripTags')
            )
        ));

        $this->add(array(
            'name' => 'inn',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        //    'useMxCheck'=>true,
                        'messages' => array(
                            'isEmpty' => "Поле обязательно для заполнения",
                        )
                    )
                ),
                array(
                    'name' => 'digits',
                    'options' => array(
                        'messages' => array(
                            'notDigits' => 'Поле должно содержать только цифры'
                        )
                    )),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 10,
                        'max' => 12,
                        'messages' => array(
                            'stringLengthTooShort' => 'Минимальная длина поля 10 символов',
                            'stringLengthTooLong' => 'Максимальная длина поля 12 символов',
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'kpp',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'digits',
                    'options' => array(
                        'messages' => array(
                            'notDigits' => 'Поле должно содержать только цифры'
                        )
                    )),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 12,
                        'messages' => array(
                            'stringLengthTooLong' => 'Максимальная длина поля 12 символов',
                        )
                    )
                )
            )
        ));
    }

}
