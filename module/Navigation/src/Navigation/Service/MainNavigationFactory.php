<?php
namespace Navigation\Service;
use Zend\Navigation\Service\DefaultNavigationFactory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainNavigationFactory
 *
 * @author kopychev
 */
class MainNavigationFactory extends DefaultNavigationFactory {
    //put your code here
        protected function getName()
    {
        return 'main';
    }
}
