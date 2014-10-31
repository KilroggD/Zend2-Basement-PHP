<?php

namespace User\Controller;

use Zend\View\Model\ViewModel;
use User\Entity\Users as UserEntity;
use Zend\Authentication\Result;
use Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author kopychev
 */
class LoginController extends MyAbstractController {

    public $form;
    protected $storage;
    protected $authservice;
    protected $container;

    /**
     * Сервис аутентификации
     * @return type
     */
    private function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('authService');
            $this->authservice->setStorage($this->getServiceLocator()->get('userStorage'));
        }

        return $this->authservice;
    }

    /*
     * Получаем контейнер сессии
     */

    private function getContainer() {
        if (!$this->container) {
            $this->container = $this->getServiceLocator()->get('userSession');
        }
        return $this->container;
    }

    /**
     * 
     * @return \User\Form
     */
    private function getForm() {
        if (!$this->form) {
            $formManager = $this->getServiceLocator()->get('FormElementManager');
            $this->form = $formManager->get('User\Form\LoginForm');
        }

        return $this->form;
    }

    public function loginAction() {

        $layout = $this->layout();
        $layout->setTemplate('login/layout');

        // Если уже залогинен
        if ($this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $request = $this->getRequest();
        $form = $this->getForm();
        $container = $this->getContainer();
        //количество неудачных попыток логина
        $attempts = isset($container->number) ? $container->number : 0;
        //если зафиксировано 3 или больше неудачные попытки логина, добавим капчу
        if ($attempts >= 2) {
            $form->setCaptcha();
        }
        //массив для ошибок
        $errors = array();
        //если пост запрос - идет логин
        if ($request->isPost()) {
            //забираем в форму данные
            $form->setData($request->getPost());
            //если форма валидна - заполнены все поля
            if ($form->isValid()) {
                //проводим авторизацию
                $authenticationService = $this->getAuthService();
                $adapter = $authenticationService->getAdapter();
                $adapter->setIdentityValue($request->getPost('login'));
                $adapter->setCredentialValue($request->getPost('password'));
                $result = $authenticationService->authenticate();
                if ($result->isValid()) {
                    //данные об успешной авторизации
                    $identity = $result->getIdentity();
                    //сущность найденного юзера
                    $userLogged = $this->getRepository("User\Entity\Users")->findOneByLogin($request->getPost('login'));
                    //сброс счетчика неудачных попыток
                    $container->number = 0;
                    //запишем идентити
                    $authenticationService->getStorage()->write($identity);
                    //запомнить меня, если установлено
                    if ($request->getPost('rememberme') == 1) {
                        $authenticationService->getStorage()->setRememberMe(1);
                    }

                    //событие об успешном логине юзера  - передаем айдишник
                    $this->getEventManager()->trigger("successfulLogin", $this, array("id" => $userLogged->getId()));
                    //переадресуем на главную
                    return $this->redirect()->toRoute('home');
                } else {
                    $errors[] = "Логин или пароль неверный, или учетная запись неактивна.";
                    if ($attempts < 3) {
                        ++$attempts;
                    }

                    $container->number = $attempts;
                }
            } else {
                $errors[] = "Проверьте правильность ввода данных";
            }
        }

        $form->setAttribute('action', $this->url()->fromRoute("login"));
        return array("form" => $form, "errors" => $errors, "attempts" => $attempts);
    }

    public function logoutAction() {
        $this->getContainer()->number = 0;
        $this->getAuthService()->getStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        $this->flashmessenger()->addMessage("Вы вышли из системы");
        return $this->redirect()->toRoute('home');
    }

}
