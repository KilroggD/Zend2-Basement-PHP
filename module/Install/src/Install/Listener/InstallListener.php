<?php

namespace Install\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminListener
 *
 * @author kopychev
 */
class InstallListener implements ListenerAggregateInterface {

    //put your code here
    protected $listeners = array(), $_sm, $target;

    public function attach(EventManagerInterface $events) {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this, 'switchLayout'), 100);
        //$this->listeners[]=$sharedEvents->attach('Install\Controller\InstallController', 'dispatch', array($this,'injectConfig'), 100); 
    }

    public function detach(EventManagerInterface $events) {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function switchLayout($e) {
        if (!$e->getError()) {
            $name = $e->getRouteMatch()->getMatchedRouteName();
            //  echo $name;
            $controller = $e->getTarget();
            if (strpos($name, 'install') !== false) {
                $controller->layout('install/layout');
                //разные раскладки для хар-к из админки и из модерского кабинета
            }
        }
    }

    public function injectConfig($e) {
        $config = $e->getApplication()->getConfig();
        $controller = $e->getTarget();
        $controller->config = $config;
    }

}
