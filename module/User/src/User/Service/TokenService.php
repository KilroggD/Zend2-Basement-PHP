<?php

namespace User\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TokenService
 * Создание шифрованных активационных токенов
 * @author kopychev
 */
class TokenService {

    public function generateToken($ident, $phrase) {
        if (is_null($ident)) {
            $token = null;
        } else {
            $time = time();
            $token = sha1($ident . $phrase . $time);
        }
        return $token;
    }

}
