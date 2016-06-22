<?php

namespace Log\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogListener
 *
 * @author kopychev
 */
class LogListener implements ListenerAggregateInterface {

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    private $mongoError = array(
        "importance" => "error", "category" => "system", "type" => "pg", "text" => "Ошибка подключения к MongoDB, запись логов выполняется в PostgreSQL", "url" => ""
    );
    protected $listeners = array(), $_sm, $_dm, $target;

    /**
     * В конструкторе определяем сервис-менеджер
     * @param type $sm
     */
    public function __construct($sm) {
        $this->_sm = $sm;
        $this->_dm = $sm->get('doctrine.documentmanager.odm_default');
    }

    /**
     * Стандартные методы attach и detach - установка и снятие событий
     * @param \Zend\EventManager\EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events) {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', 'log', array($this, 'log'), 100);
    }

    public function detach(EventManagerInterface $events) {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function log($e) {
        $url = $e->getTarget()->getRequest()->getUri()->__toString();
        $params = $e->getParams();
        $params["url"] = $url;
        //если не коннектит монго - пишем все в пг
        try {
            $this->_dm->getConnection()->connect();
        } catch (\MongoConnectionException $ex) {
            $params["type"] = "pg";
            $this->_sm->get("logService")->write($this->mongoError);
        }
        $this->_sm->get("logService")->write($params);
        return true;
    }

}
