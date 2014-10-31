<?php
namespace Application\Common;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Содержит универсальные хелперы для всего
 *
 * @author kopychev
 */
class MyHelper {
    //put your code here
          /**
       * Поиск по ключу-значению в многомерном массиве. Возвращает полный подмассив
       * @param mixed $value
       * @param mixed $key
       * @param array $array
       * @return mixed
       */
     public static function searcharray($value, $key, $array) {
   foreach ($array as $k => $val) {
       if ($val[$key] == $value) {
           return $val;
       }
   }
   return null;
} 

    public static function versionDiff($props, $obj1, $obj2){
        $diff=array();
        if($props && is_object($obj1) && is_object($obj2)){
        foreach($props as $property){
            if(method_exists($obj1, 'get' . ucfirst($property)) && method_exists($obj2, 'get' . ucfirst($property))){
         $val1= call_user_func(array($obj1, 'get' . ucfirst($property)));   
         $val2= call_user_func(array($obj2, 'get' . ucfirst($property)));
         if($val1!==$val2){
             $diff[]=$property;
             return $diff;
         }
            }
        }                       
        }
            return false;
    }


    
}
