<?php
namespace Organization\Form;
use Zend\Form\Form;
use Zend\Form\Element;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrganizationForm
 *
 * @author kopychev
 */
class OrganizationForm extends Form {
    //put your code here
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    public function __construct($em) {
        parent::__construct();
        $this->setAttribute("class", "admin-form");
     $this->setAttribute("id","org-form");
    $this->setAttribute("method","POST");
        $this->em=$em;
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'size'=>140,
                'id'=>'name'
                           ),
            'options'=>array(
                'label'=>'Наименование организации:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));  
               $this->add(array(
            'name' => 'shortName',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'size'=>140,
                'id'=>'sortName'
                           ),
            'options'=>array(
                'label'=>'Сокращенное наименование:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));   
       $this->add(array(
            'name' => 'inn',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'size'=>12,
                'id'=>'inn',
                'maxlength'=>12
                           ),
            'options'=>array(
                'label'=>'ИНН:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));       
          
       $this->add(array(
            'name' => 'kpp',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                    'size'=>12,
                'id'=>'kpp',
                'maxlength'=>12
                           ),
            'options'=>array(
                'label'=>'КПП:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
                )
            )
        ));       
         
                     $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type' => 'text',
                'class'=>'medium-input form-control',
                'size'=>140,
                'id'=>'address'
                           ),
            'options'=>array(
                'label'=>'Юридический адрес:',
                'label_attributes'=>array(
                    'class'=>'col-md-3 control-label'
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
            'object_manager'     => $this->em,
            'target_class'       => 'Organization\Entity\OrganizationTypes',
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
                    $this->add(array(
             'name' => 'submit',
             'attributes' => array(
                 'type' => 'submit',
                 'value' => 'Сохранить',
             ),
         ));                                
                                           
             
    }
    
}
