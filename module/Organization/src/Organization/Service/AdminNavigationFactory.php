<?php

namespace Organization\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminNavigationFactory
 *
 * @author kopychev
 */
class AdminNavigationFactory extends DefaultNavigationFactory {

    protected function getName() {
        return 'organization';
    }

}
