<?php

namespace Log\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Абстрактный контроллер, содержащий общие функции для работы с сущностями, формами, вьюшками
 *
 * @author kopychev
 */
class MyAbstractController extends AbstractActionController {

    //put your code here

    protected $em, $dm, $viewrenderer;
    public $base, $userParams, $query, $refUrl;

    /**
     * Обработчик события dispatch - проверка на ошибку
     * @param \Zend\Mvc\MvcEvent $e
     * @return boolean
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        if ($e->getError()) {
            return false;
        } else {
            //сохраним данные из URL гет-запроса
            $referer = $this->getRequest()->getHeader('Referer');
            $this->refUrl = $referer ? $referer->getUri() : $this->url()->fromRoute("home");
            if ($this->params()->fromQuery()) {
                $this->query = $this->params()->fromQuery();
            }
        }
        parent::onDispatch($e);
    }

    /**
     * Вернуть менеджер сущностей DoctrineORM
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager() {
        if (null === $this->em) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->em;
    }

    /**
     * Установить менеджер сущностей DoctrineORM
     * @param type $em
     * @return \User\Controller\MyAbstractController
     */
    protected function setEntityManager($em) {
        $this->em = $em;
        return $this;
    }

    protected function getDocumentManager() {
        if (null === $this->dm) {
            $this->setDocumentManager($this->getServiceLocator()->get('doctrine.documentmanager.odm_default'));
        }
        return $this->dm;
    }

    protected function setDocumentManager($dm) {
        $this->dm = $dm;
        return $this;
    }

    /**
     * Возвращает репозиторий DoctrineORM
     * @param string $key
     * @return $repository
     */
    protected function getRepository($key) {
        return $this->getEntityManager()->getRepository($key);
    }

    /**
     * Вернуть/установить ViewRenderer
     * @return type
     */
    protected function getViewRenderer() {
        if (null === $this->viewrenderer) {
            $this->setViewRenderer($this->getServiceLocator()->get("ViewRenderer"));
        }
        return $this->viewrenderer;
    }

    protected function setViewRenderer($em) {
        $this->viewrenderer = $em;
        return $this;
    }

    /**
     * Вернуть форму
     * @param string $key
     * @return form
     */
    public function getFormByKey($key) {
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get($key);
        return $form;
    }

}
