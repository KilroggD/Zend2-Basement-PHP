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
    const ADMIN="1", USER="2", GUEST="3";
    private $initials=array(
        self::ADMIN=>"Администратор",
        self::USER=>"Пользователь",
        self::GUEST=>"Гость"
    );
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
    
    /**
     * создание начальных ролей (например, при инсталляции)
     */
    public function initRoles(){        
        foreach($this->initials as $id=>$name){
            $role=new \Acl\Entity\AclRoles();
            $role->setName($name);
            $role->setBuiltIn(1);     
            $this->getEntityManager()->persist($role);
        }
        $this->getEntityManager()->flush();
        return $this;
    }
    
}
