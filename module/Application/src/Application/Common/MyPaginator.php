<?php
namespace Application\Common;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
 use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
 use Application\Exception\QbIsNullException as QbIsNullException;
 use Zend\Paginator\Paginator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyPaginator
 * Общий класс для постраничной навигации
 * Расширяет пагинатор зенда и связывает с доктриной
 * @author kopychev
 */
class MyPaginator extends Paginator {
    //put your code here
    public $items, $pages;
public function __construct($query){
    if(!$query){
        throw new QbIsNullException("Query builder is null",null,null);
    }
     $adapter = new DoctrineAdapter(new ORMPaginator($query));
     parent::__construct($adapter);  
         }
                       
}