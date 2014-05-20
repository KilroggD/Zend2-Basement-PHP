<?php
namespace Acl\View\Helper; 
use Zend\View\Helper\AbstractHelper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AllowedHelper
 * Проверка имеет ли юзер разрешение на действие
 * @author kopychev
 */
class AllowedHelper extends AbstractHelper{
    //put your code here
    public function __invoke($res,$action,$roles=null) {
        if(!$roles){
            $roles=$this->getView()->layout()->currentRoles;
        }
        $acl=$this->getView()->layout()->acl;
        //проверяем, разрешено ли хотя бы 1 роли это действие
        foreach($roles as $role){
            if($acl->isAllowed((string)$role,$res,$action)) {
                return true;
            }
        }
        //если не нашли совпадений - действие запрещено
        return false;
    }
}
