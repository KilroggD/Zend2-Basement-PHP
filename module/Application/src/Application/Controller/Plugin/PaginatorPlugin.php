<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaginatorPlugin
 * Плагин для пагинации результатов поиска. В функциях поиска нужно возвращать query builder
 * @author kopychev
 */
class PaginatorPlugin extends AbstractPlugin {

    //put your code here
    protected $items, $count, $page;

    /**
     * 
     * @param QueryBuilder $qb
     * @param integer $limit  - количество элементов на странице
     * @param integer $page - номер текущей страницы
     * @return \Application\Controller\Plugin\PaginatorPlugin
     */
    public function paginate($qb, $limit = 20, $page = 1) {
        $paginator = new \Application\Common\MyPaginator($qb);
        $paginator->setDefaultItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $this->items = $paginator->getItemsByPage($page);
        $this->count = $paginator->count();
        $this->page = $paginator->getCurrentPageNumber();
        return $this;
    }

    public function getItems() {
        return $this->items;
    }

    public function getCount() {
        return $this->count;
    }

    public function getPage() {
        return $this->page;
    }

}
