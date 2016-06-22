<?php

namespace Admin\Listener;

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
class AdminListener implements ListenerAggregateInterface {

    //put your code here
    protected $listeners = array(), $_sm, $target;

    public function attach(EventManagerInterface $events) {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this, 'switchLayout'), 10);
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
            if (strpos($name, 'admin') !== false) {
                $controller->layout('admin/layout');
                //разные раскладки для хар-к из админки и из модерского кабинета
            }
        }
    }

}
