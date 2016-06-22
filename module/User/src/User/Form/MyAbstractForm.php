<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractForm
 *
 * @author kopychev
 */
abstract class MyAbstractForm extends Form {

    //put your code here
    protected $captcha;
    public $basePath;

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
    }

    public function setCaptcha() {
        /**
         * Добавляет капчу если ее нету
         */
        if (!$this->has('captcha')) {
            $dirdata = './data';
            $captchaImage = new \Zend\Captcha\Image(array(
                'font' => $dirdata . '/fonts/Roboto-Regular.ttf',
                'width' => '350',
                'height' => '55',
                'dotNoiseLevel' => 20,
                'lineNoiseLevel' => 2)
            );
            $captchaImage->setMessages(array("badCaptcha" => "Введен неверный код"));
            $captchaImage->setImgDir($dirdata . '/../public/images/captcha');
            $captchaImage->setImgUrl('/images/captcha');
            $captchaImage->setMessages(array("badCaptcha" => "Введен неверный код"));
            $captcha = new \Zend\Form\Element\Captcha('captcha');
            $captcha->setAttributes(array(
                "id" => 'captcha'
            ));

            $captcha->setOptions(array(
                'label' => 'Введите код с картинки',
                'label_attributes' => array(
                    'class' => 'control-label',
                ),
                'captcha' => $captchaImage,
            ));
            $captcha->setAttributes(array("class" => "captcha form-control", "autocomplete" => "off"));
            $this->add($captcha);
        }
    }

    public function getCaptchaForJson() {
        if ($this->has("captcha")) {
            $captcha = $this->get("captcha")->getCaptcha();
            $data['id'] = $captcha->generate();
            $data['src'] = $captcha->getImgUrl() . $captcha->getId() . $captcha->getSuffix();
            return $data;
        }
        return false;
    }

    public function setBasePath($path) {
        if (!$this->basePath) {
            $this->basePath = $path;
        }
        return $path;
    }

}
