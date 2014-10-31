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
    }
    
    
    public function init(){
        $this->add(array(
              'name'=>'actualVersion',
             'type' => 'OrganizationProfileFieldset',             
         ));      
                      $this->add(array(
             'name' => 'submit',
             'attributes' => array(
                 'type' => 'submit',
                 'value' => 'Сохранить',
             ),
         ));       
    }
    
    
}
