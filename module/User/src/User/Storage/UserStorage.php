<?php

namespace User\Storage;

use Zend\Authentication\Storage\Session;
use Zend\Session\Container;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Хранилище данных авторизованного юзера, функции "запомнить меня"
 */

/**
 * Description of UserStorage
 *
 * @author kopychev
 */
class UserStorage extends Session {

    /**
     * "Запомнить" меня
     * @param integer $rememberMe
     * @param integer $time
     */
    public function setRememberMe($rememberMe = 0, $time = 1209600) {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    /**
     * "Забыть" меня
     */
    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }

}
