<?php

namespace User\Controller;

use Zend\View\Model\ViewModel;
use User\Entity;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PasswordController
 * Восстановление пароля и смена пароля
 * @author kopychev
 */
class PasswordController extends MyAbstractController {

    public $userParams, $form;
    protected $viewModel;

    /**
     * Форма "Забыл пароль", отправка линка на одноразовый вход
     * @return type
     */
    public function sendpassAction() {
        $error = array();
        $layout = $this->layout();
        $layout->setTemplate('login/layout');
        $form = $this->getFormByKey('User\Form\ForgotPassword');
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $repoUser = $this->getRepository('User\Entity\Users');
                $userFound = $repoUser->findOneByEmail($this->getRequest()->getPost('email'));
                $error = $this->wrongStatus($userFound);
                if (!$error) {
                    $id = $userFound->getId();
                    $passReq = new Entity\UserPasswordChange();
                    $tokenkey = $this->getServiceLocator()->get("tokenService")->generateToken($userFound->getEmail(), 'SomeSecretTextKey' . rand(1000, 3000));
                    $link = $this->base . $this->url()->fromRoute('password/new', array("uid" => $userFound->getId(), "token" => $tokenkey));
                    //заполняем и создаем запись о запросе на смену пароля
                    $passReq->setToken($tokenkey);
                    $passReq->setUser($userFound);
                    $this->getEntityManager()->persist($passReq);
                    $userFound->setPasswordChange($passReq);
                    $this->getEntityManager()->flush();
                    //событие для отправки почты
                    $this->getEventManager()->trigger('passwordForgot', $this, array("email" => $userFound->getEmail(), "login" => $userFound->getLogin(), "link" => $link));
                    $this->flashMessenger()->addMessage("Дальнейшие инструкции высланы на указанный email");
                    return $this->redirect()->toRoute("home");
                }
            }
        }
        return array("form" => $form, "errors" => $error);
    }

    /**
     * Изменяет пароль юзеру по ссылке "забытого пароля"
     */
    public function newAction() {
        $error = array();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('uid');
        $token = $this->params()->fromRoute('token');
        $form = $this->getFormByKey('User\Form\NewPassword');
        $form->setAttribute("action", $this->url()->fromRoute("password/new", array("uid" => $id, "token" => $token)));
        if (!$id || !$token) {
            $this->flashMessenger()->addMessage("Неверная ссылка");
            return $this->redirect()->toRoute("home");
        }
        /**
         * Сразу проверим юзера и наличие запроса на восстан
         */
        $user = $this->getRepository('User\Entity\Users')->find($id);
        $passReq = $user->getPasswordChange();
        if (!$user || !$passReq) {
            $this->flashMessenger()->addMessage("Неверная ссылка");
            return $this->redirect()->toRoute("home");
        }

        if ($passReq->getToken() != $token) {
            $this->flashMessenger()->addMessage("Неверная ссылка");
            return $this->redirect()->toRoute("home");
        }
        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                //если все валидно - меняем пароль убираем реквест на смену пароля
                $user->setStatus(\User\Entity\Users::ACTIVE);
                $user->setPassword(md5($post["password"]));
                $this->getEntityManager()->remove($passReq);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addMessage("Пароль успешно изменен");
                return $this->redirect()->toRoute('home');
            }
        }
        //если не пост, а загрузка формы - сбрасываем пароль
        else {
            $user->setStatus(Entity\Users::CHANGEPWD);
            $this->getEntityManager()->flush();
        }
        return array("form" => $form, "errors" => $error);
    }

    /**
     * Проверяет состояние найденного юзера
     * @return array
     * @param array $userFound
     */
    private function wrongStatus($userFound) {
        $error = array();
        if (!$userFound) {
            $error["email"] = "Пользователя с таким адресом электронной почты не существует, либо запись неактивна";
        } else {
            if ($userFound->getStatus() != \User\Entity\Users::ACTIVE) {
                $error["email"] = "Пользователя с таким адресом электронной почты не существует, либо запись неактивна";
            }
            if ($userFound->getPasswordChange()) {
                $error["email"] = "Вы уже создавали запрос на смену пароля";
            }
        }
        return $error;
    }

}
