<?php
namespace Organization\Repository;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Репозиторий для организаций. содержит кастомные функции
 *
 * @author kopychev
 */
class OrganizationsRepository extends EntityRepository{
    //put your code here
    /**
     * 
     * @param array $query - поисковый запрос
     * @param type $maxcount - максимальное количество элементов на странице
     */
    public function search($query){
        $qb=$this->createQueryBuilder('actual')->leftJoin("actual.actualVersion", "orgs")->andWhere("actual.builtIn!=1")->andWhere("actual.status!=0");        
        if(isset($query["inn"])){            
            $qb->andWhere($qb->expr()->like("orgs.inn",'?1'));
            $qb->setParameter(1,$query["inn"]."%");
        }
        if(isset($query["name"])){
            $qb->andWhere($qb->expr()->orX($qb->expr()->like("LOWER(orgs.shortName)",'?2'),$qb->expr()->like("LOWER(orgs.name)", '?2')));
            $qb->setParameter(2,  mb_strtolower($query["name"]."%"));
        }
        if(isset($query["sortby"])){
            $qb->orderBy('orgs.'.$query["sortby"],$query["sortorder"]);
        }
        else {
        $qb->orderBy('orgs.created', 'ASC');        
        $qb->orderBy('orgs.shortName','ASC');
        }        
        return $qb;
    }
    
    public function autocomplete($query){
$qb=$this->createQueryBuilder('actual')->leftJoin("actual.actualVersion", "orgs");   
if($query){
            $qb->orWhere($qb->expr()->like("orgs.inn",'?1'));
            $qb->orWhere($qb->expr()->like("LOWER(orgs.shortName)",'?1'));
            $qb->orWhere($qb->expr()->like("LOWER(orgs.name)", '?1'));
            $qb->setParameter(1,  mb_strtolower($query)."%");
           
        }
       $qb->andWhere(("actual.builtIn!=1"))->andWhere("actual.status!=0");
         $qb->orderBy('orgs.shortName','ASC');
          $query=$qb->getQuery();
            $result=$query->getArrayResult();           
            return $result;
            }
            
     public function getByVal($val){
         $qb=$this->createQueryBuilder("actual");
         $qb->andWhere($qb->expr()->in("actual.id", $val));
         $qb->andWhere("actual.builtIn!=1")->andWhere("actual.status!=0");
         $query=$qb->getQuery();
         $result=$query->getArrayResult();           
         return $result;
     }
    
     public function selectList(){
         $qb=$this->createQueryBuilder("actual")->leftJoin("actual.actualVersion", "orgs");   
         $qb->select("actual.id as id", "orgs.name as name");
         $query=$qb->getQuery();
         return $query->getResult();
                 }
     
    //валидация на уникальность по какому-либо полю
    public function validateUnique($field,$value){
        return $this->findOneBy(array($field=>$value));
    }

    
}