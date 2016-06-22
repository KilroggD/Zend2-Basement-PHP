<?php

namespace Acl\View\Helper;

use Zend\View\Helper\AbstractHelper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclListHelper
 *
 * @author kopychev
 */
class AclListHelper extends AbstractHelper {

    /**
     * Вывод с группировкой древовидного массива acl[group][module][action]
     * @param array $acls
     */
    public function __invoke($acls, $editable = null) {
        $emptyTable = 1;
        $html = "";
        $html.="<table class='table table-bordered'>"
                . "<thead><td>Разрешение</td><td>Контроллер</td><td>Действие</td><td>Системное?</td><td>Не проверять?</td></thead><tbody>";
        //перебираем группы        
        foreach ($acls as $group => $modules) {
//модли
            $html.="<tr><td colspan='5'><h3>Группа разрешений <span class='label label-default'>$group</span></h3></td></tr>";
            foreach ($modules as $module => $actions) {
                //экшены
                $html.="<tr><td colspan='5'><h4>Контроллер: <span class='label label-info'>$module</span></h4></td></tr>";
                if ($actions) {
                    $emptyTable = 0;
                }
                foreach ($actions as $action => $permission) {
                    $html.="<tr>"
                            . "<td>" . $permission['description'] . "";
                    if ($editable) {
                        $html.="<span class='acl-editable-links'>"
                                . "  <a href='" . $this->getView()->url("acl\\admin/edit", array("id" => $permission["id"])) . "' class='btn btn-sm btn-default'><span class='glyphicon glyphicon-pencil'></span></a>";
                        $html.="<a href='" . $this->getView()->url("acl\\admin/delete", array("id" => $permission["id"])) . "' class='btn btn-sm btn-danger'><span class='glyphicon glyphicon-remove'></span></a>"
                                . "</span>";
                    }
                    $html.= "</td><td>$module</td><td>$action</td><td>" . $permission['system'] . "</td><td>" . $permission['exclude'] . "</td>"
                            . "</tr>";
                }
            }
        }
        $html.="</tbody></table>";
        //если действий нету
        if ($emptyTable) {
            return false;
        }
        return $html;
    }

}
