<?php

namespace Email\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InstallService
 *
 * @author kopychev
 */
class InstallService {

    //put your code here
    protected static $templates = array(
        "passwordChange" => array(
            "template" => "Здравствуйте, {{LOGIN}}! Ваш адрес электронной почты: {{TO}} был указан для изменения пароля на сайте. Перейдите по <a href='{{LINK}}'>ссылке</a> для одноразового входа на сайт. В случае, если смена пароля была инициирована не вами, проигнорируйте данное письмо C уважением, Администрация сайта.",
            "subject" => "Изменение пароля на сайте"
        ),
        "emailChangeTo" => array(
            "template" => "Здравствуйте, {{LOGIN}}! Для Вашей учетной записи был изменен адрес электронной почты с адреса {{OLDEMAIL}} на этот. Если это действие было совершено не Вами, срочно свяжитесь с Администрацией сайта. C уважением, Администрация сайта.",
            "subject" => "Изменение email адреса учетной записи"
        ),
        "emailChangeFrom" => array(
            "template" => "Здравствуйте, {{LOGIN}}! Для Вашей учетной записи был изменен адрес электронной почты на {{EMAIL}}. Если это действие было совершено не Вами, срочно свяжитесь с Администрацией сайта. C уважением, Администрация сайта.",
            "subject" => "Изменение email адреса учетной записи"
        ),
        "activationLink" => array(
            "template" => "Здравствуйте, {{LOGIN}}! На Ваш электронный адрес была зарегистрирована учетная запись. Для успешной активации, пройдите <a href=\"{{LINK}}\" target=\"_blank\">по ссылке</a>. Ссылка действительна в течение 7 дней. C уважением, Администрация сайта.",
            "subject" => "Активация учетной записи"
        ),
    );

    public static function install($em) {
        foreach (self::$templates as $key => $tpl) {
            $template = new \Email\Entity\EmailTemplates();
            $template->setKey($key);
            $template->setSubject($tpl["subject"]);
            $template->setTemplate($tpl["template"]);
            $em->persist($template);
        }
        $em->flush();
        return true;
    }

}
