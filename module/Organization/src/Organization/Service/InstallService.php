<?php
namespace Organization\Service;
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
protected static $defaultOrg=array(
    "name"=>"Не выбрано",
     "shortName"=>"Не выбрано",
    "inn"=>"0000000000",   
    "kpp"=>"0000000000",
    "address"=>"",
    "builtIt"=>1
    );
protected static $defaultType="Без типа";
public static function install($em){
    $type=new \Organization\Entity\OrganizationTypes();
    $type->setName(self::$defaultType);
    $type->setBuiltIn(1);
    $em->persist($type);
    $em->flush();
    $d=self::$defaultOrg;
    $org=new \Organization\Entity\Organizations();
    $org->setName($d["name"]);
    $org->setShortName($d["shortName"]);
    $org->setInn($d["inn"])->setKpp($d["kpp"])->setAddress($d["address"])->setBuiltIn(1)->setType($type);
    $em->persist($org);
    $em->flush();
    return true;
}

}
