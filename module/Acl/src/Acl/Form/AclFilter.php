<?php

namespace Acl\Form;

use Zend\InputFilter\InputFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclFilter
 * Фильтр с валидатором для Acl
 * @author kopychev
 */
class AclFilter extends InputFilter {

    //put your code here
    public function __construct() {
        $this->add(array(
            'name' => 'description',
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => "Укажите описание разрешения",
                        )
                    )
                ),
            ),
        ));
    }

}
