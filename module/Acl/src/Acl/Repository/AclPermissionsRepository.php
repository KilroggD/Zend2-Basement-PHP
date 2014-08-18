<?php
namespace Acl\Repository;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclPermissionsRepository
 *
 * @author kopychev
 */
class AclPermissionsRepository extends EntityRepository {
    //put your code here
    public function getAllIncluded(){
        $qb=$this->createQueryBuilder('p')->select('p.id,p.description,p.system,p.controller,p.grp')->where("p.exclude=0")->orderBy("p.grp",'ASC')->orderBy("p.controller","ASC");
        $query=$qb->getQuery();
        return $query->getArrayResult();
        
    }
    
       public function addAcls($acls){
       foreach($acls as $group=>$modules){
              foreach($modules as $module=>$actions){
                  foreach($actions as $action=>$permission){
                      extract($permission);
                      $aclPermission=new \Acl\Entity\AclPermissions();
                      $aclPermission->setAction($action);
                      $aclPermission->setController($module);
                      $aclPermission->setGrp($group);
                      $aclPermission->setDescription($description);
                      $aclPermission->setExclude($exclude);
                      $aclPermission->setSystem($system);
                      $this->getEntityManager()->persist($aclPermission);
                           }
              }
         }
                     $this->getEntityManager()->flush();
                     return true;
                               }
                               
                                   /**
     * Удаление коллекции entities Acl
     * @param array $records
     */
   public function removeAcls($records){
       foreach($records as $record){
           $this->getEntityManager()->remove($record);
       }
       $this->getEntityManager()->flush();
   } 
    
    
}
