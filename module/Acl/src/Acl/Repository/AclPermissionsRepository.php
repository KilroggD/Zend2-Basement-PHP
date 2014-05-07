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
    
}
