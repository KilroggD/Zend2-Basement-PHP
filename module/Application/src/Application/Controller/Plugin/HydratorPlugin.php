<?php
namespace Application\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HydratorPlugin
 * Преобразование сущности в массив данных
 * @author kopychev
 */
class HydratorPlugin extends AbstractPlugin{
    
    public function hydrate($entity){
        $hydrator=new DoctrineHydrator($this->getController()->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        return $hydrator->extract($entity);
    }
    
}
