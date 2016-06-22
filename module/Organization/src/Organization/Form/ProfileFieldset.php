<?php

namespace Organization\Form;

use Organization\Entity\OrganizationProfile;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

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
class ProfileFieldset extends Fieldset implements InputFilterProviderInterface {

    //put your code here

    public function __construct($em) {
        parent::__construct('actualVersion');
        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em))->setObject(new OrganizationProfile());
        $this->setLabel('Сведения об организации');
        /*    $this->add(array(
          "name"=>"id",
          "type"=>"hidden"
          )); */
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 140,
                'id' => 'name'
            ),
            'options' => array(
                'label' => 'Наименование организации:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));
        $this->add(array(
            'name' => 'shortName',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 140,
                'id' => 'sortName'
            ),
            'options' => array(
                'label' => 'Сокращенное наименование:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));
        $this->add(array(
            'name' => 'inn',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 12,
                'id' => 'inn',
                'maxlength' => 12
            ),
            'options' => array(
                'label' => 'ИНН:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));

        $this->add(array(
            'name' => 'kpp',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 12,
                'id' => 'kpp',
                'maxlength' => 12
            ),
            'options' => array(
                'label' => 'КПП:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));

        $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type' => 'text',
                'class' => 'medium-input form-control',
                'size' => 140,
                'id' => 'address'
            ),
            'options' => array(
                'label' => 'Юридический адрес:',
                'label_attributes' => array(
                    'class' => 'col-md-3 control-label'
                )
            )
        ));
        /**
         * Тип организации
         */
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'type',
                    'options' => array(
                        'label' => 'Тип организации',
                        'object_manager' => $em,
                        'target_class' => 'Organization\Entity\OrganizationTypes',
                        'property' => 'name',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                // Use key 'orderBy' if using ORM
                                'orderBy' => array('name' => 'ASC'),
                            ),
                        ),
                    ),
                )
        );
    }

    public function getInputFilterSpecification() {
        return array(
        );
    }

}
