<?php
namespace Acl\Repository;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclRolesRepository
 *
 * @author kopychev
 */
class AclRolesRepository extends EntityRepository{
    //put your code here
    
    public function getRolesWithPermissions(){
        $roles=array();
        $result=$this->findAll();
        foreach($result as $role){
            $roles[]=array(
              "id"=>$role->getId(),
               "name"=>$role->getName(),
                "builtIn"=>$role->getBuiltIn(),
                  "permissions"=>$role->getPermissions()->map(function($permission){return $permission->getId();})->toArray(),
            );
        }
            return $roles;
    }
    
}
