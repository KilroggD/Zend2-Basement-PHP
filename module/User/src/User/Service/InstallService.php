<?php

namespace User\Service;

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

    public static function install($em) {
        if (!mkdir("./public/img/captcha", 0775, true)) {
            $error = error_get_last();
            return false;
        }
        return true;
    }

}
