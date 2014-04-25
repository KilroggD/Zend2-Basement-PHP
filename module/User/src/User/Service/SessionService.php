<?php
namespace User\Service;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Сервис работы с сессией
 */

/**
 * Description of SessionService
 * Класс для работы с сессией
 * @author kopychev
 */
class SessionService {
    /**
     * Контейнер сессии
     * @var \Zend\Session\Container
     */
        protected $sessionContainer;
        /**
         * Создать контейнер сессии 
         * @param type $sessionContainer
         */
    public function setSessionContainer($sessionContainer) {
        $this->sessionContainer = $sessionContainer;
    }
/**
 * Вернуть контейнер сессии
 * @return \Zend\Session\Container
 */
    public function getSessionContainer() {
        if(!$this->sessionContainer){
            $sessionContainer = new \Zend\Session\Container('user');
            //$sessionContainer->data=array();
            $this->setSessionContainer($sessionContainer);
        }
        return $this->sessionContainer;
    }
}
