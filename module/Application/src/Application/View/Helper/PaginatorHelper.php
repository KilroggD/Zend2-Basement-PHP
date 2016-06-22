<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyPaginatorHelper
 * пагинация чего-либо с указанием маршрута и параметров
 * @author kopychev
 */
class PaginatorHelper extends AbstractHelper {

    /**
     * 
     * @param int $pages - количество страницы
     * @param int $pagelimit - сколько номеров страниц выводить
     * @param int $current -  текущий номер страницы
     * @param string $route - роут, на который указывает ссылка
     * @param array $query - параметры поиска
     * @return string $html - html код постраничной навигации
     */
    public function __invoke($pages, $pagelimit, $current = 1, $route, $query = array(), $params = array()) {
        $ints = floor($pages / $pagelimit);
        $before = floor(($current - 1) / $pagelimit);
        $start = ($before * $pagelimit) + 1;
        $html = '<ul class="pagination">';
        if ($before > 0) {
            $query["page"] = $before * $pagelimit;
            $html.='<li><a href="' . $this->view->url($route, $params, array('query' => $query)) . '"><<</a></li>';
        }

        for ($i = $start; $i < $start + $pagelimit; $i++) {
            $query["page"] = $i;
            $html.='<li class="' . (($i == $current) ? 'active' : '') . '" ><a href="' . $this->view->url($route, $params, array('query' => $query)) . '">' . $i . '</a></li>';
            if ($i >= $pages) {
                $i++;
                break;
            }
        }
        if ($i <= $pages) {
            $query["page"] = $i;

            $html.='<li><a href="' . $this->view->url($route, $params, array('query' => $query)) . '">>></a></li>';
        }
        $html.='</ul>';
        return $html;
    }

}
