<?php
namespace User\Repository;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRepository
 *
 * @author kopychev
 */
class UsersRepository extends EntityRepository{
    //put your code here
    /**
     * 
     * @param array $query - поисковый запрос
     * @param type $maxcount - максимальное количество элементов на странице
     */
    public function search($query){
        $qb=$this->createQueryBuilder('users');        
        if(isset($query["role"])){
            $qb->leftJoin('users.roles','roles');
            $qb->andWhere("roles.id=?1");
            $qb->setParameter(1,(int)$query["role"]);
        }
        if(isset($query["status"])){
            $qb->andWhere("users.status=?2");
            $qb->setParameter(2,$query["status"]);
        }
        if(isset($query["sortby"])){
            $qb->orderBy('users.'.$query["sortby"],$query["sortorder"]);
        }
        else {
        $qb->orderBy('users.created', 'ASC');        
        $qb->orderBy('users.login','ASC');
        }        
        return $qb;
    }
    //валидация на уникальность по какому-либо полю
    public function validateUnique($field,$value){
        return $this->findOneBy(array($field=>$value));
    }

    
}
