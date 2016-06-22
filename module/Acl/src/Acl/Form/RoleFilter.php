<?php

namespace Acl\Form;

use Zend\InputFilter\InputFilter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Валидатор для формы ролей
 *
 * @author kopychev
 */
class RoleFilter extends InputFilter {

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
                            'isEmpty' => "Действие не выполнено. Наименование роли не должно быть пустым",
                        )
                    )
                ),
            )
        ));
    }

}
