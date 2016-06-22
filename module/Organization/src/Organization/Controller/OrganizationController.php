<?php

namespace Organization\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrganizationController
 *
 * @author kopychev
 */
class OrganizationController extends MyAbstractController {

    //put your code here
    public function indexAction() {
        //В случае автокомплита 
        $autocomplete = $this->params()->fromQuery("autocomplete");
        if ($autocomplete) {
            $query = $this->params()->fromQuery("query");
            $val = $this->params()->fromQuery("val");
            $repository = $this->getRepository("Organization\Entity\Organizations");
            if ($query) {
                $result = $repository->autocomplete($query);
            }
            if ($val) {
                $result = $repository->getByVal(explode(",", $val));
            }
            $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            return $this->getResponse()->setContent(\Zend\Json\Json::encode($result));
        }
    }

}
