<?php
namespace Application\Interfaces;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SimpleCrudInterface
 *
 * @author kopychev
 */
interface SimpleCrudInterface {
    //put your code here
    public function indexAction();
    public function addAction();
    public function editAction();
    public function deleteAction();
    
}
