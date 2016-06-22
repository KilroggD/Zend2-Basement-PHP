<?php

namespace Update\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InstallService
 *
 * @author Kilrogg
 */
class InstallService {

    public static function install($em) {
        if (!mkdir("./sql/migrations", 0775, true)) {
            $error = error_get_last();
            return false;
        }
        return true;
    }

}
