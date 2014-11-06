<?php

namespace Update\Service;
use Doctrine\Common\ClassLoader;
use Symfony\Component\Console\Tester\CommandTester;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Configuration\YamlConfiguration;
use Doctrine\DBAL\Migrations\Migration;
use Doctrine\ORM\Mapping\Driver\YamlDriver as YamlDriverORM;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Сервис для работы с миграциями
 *
 * @author kopychev
 */
class MigrationService {
    //put your code here
    const CONF_PATH="./config/migrations.yml";
    private $app,$em, $ct, $conf, $main_em, $yml;    
    /**
     * 
     * @param type $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $paths=$this->getYmls();
        $this->main_em=$em;
              $classLoader = new ClassLoader('Doctrine\DBAL\Migrations', './vendor/doctrine/migrations/lib');
        $classLoader->register();
            $cache = new \Doctrine\Common\Cache\ArrayCache;
          $yml=new YamlDriverORM($paths);
          $this->yml=$yml;
          $conn=$em->getConnection();
          $config=$em->getConfiguration();
          $drv=$config->newDefaultAnnotationDriver($paths);
          $evm=$em->getEventManager();          
          $config->setMetadataDriverImpl($yml);
          $config->setMetadataCacheImpl($cache);
          $this->em=  \Doctrine\ORM\EntityManager::create($conn, $config, $evm);
        $this->getApplication();     
        $this->conf=new \Doctrine\DBAL\Migrations\Configuration\YamlConfiguration($this->em->getConnection());        
        $this->conf->load(self::CONF_PATH);
    }
    /**
     * Текущий статус миграций
     */
    public function getMigrations(){

        return array ("migrated"=>$this->conf->getMigratedVersions(),"available"=>$this->conf->getAvailableVersions());
    }
    
    /**
     * Выполнение команды diff
     * @return int
     */
    public function createDiff(){
        $command="migrations:diff";
        $params=array("--configuration"=>self::CONF_PATH);
        $response=$this->exec($command, $params);
        return $response->getStatusCode();
    }
    
    /**
     * Осуществить миграцию до версии
     * @param int $version
     * @return \Update\Service\MigrationException | string
     */
    public function migrate($version){
        //экземпляр миграции
        $migration=new Migration($this->conf);    
        try {
            $migration->migrate($version);
            return "Осуществлена миграция ".$version;            
        } catch (\Doctrine\DBAL\Migrations\MigrationException $ex) {
            echo 1;
            return $ex;
        }
    }
            /**
             * Удаление версии миграции
             * @param int $version
             * @return int
             */
    public function delete($version){
        $command="migrations:version";
        $params=array("--configuration"=>self::CONF_PATH,"version"=>$version,"--delete"=>1);
   //     $options=array("--delete"=>1);
        $response=$this->exec($command, $params)->getStatusCode();
        return $response;
    }
    
    public function updateEntity(){
       $classes=$this->getDest();
       $messages=array();
       foreach($classes as $filter=>$path){
       $cmd=$this->exec("orm::entities", array("dest-path"=>$path,"--filter"=>$filter,"--generate-annotations"=>1));
       $messages[]=$cmd->getDisplay();
       }
       return $messages;
    }
    
    private function getApplication(){
    if(!$this->app){
        $db=$this->em->getConnection();
        $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($db),
    'dialog' => new \Symfony\Component\Console\Helper\DialogHelper(),
               'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($this->em)
));
        $this->app= new \Symfony\Component\Console\Application('Doctrine Database Migrations');
        $this->app->setHelperSet($helperSet);
        $this->app->addCommands(array(
    // ...

    // Migrations Commands
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand(),
    //generate entities command
            new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand()
));
    }    
    return $this->app;
    }
    
    /**
     * Выполнить команду с выбранными параметрами и опциями
     * @param string $command
     * @param array $params
     * @param array $options
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    private function exec($command,$params=array(), $options=array()){
        $cmd=$this->app->find($command);
        $commandTester=new CommandTester($cmd);
        $input=array("command"=>$command);
        if($params){
            $input=  array_merge($input,$params);
        }
        $commandTester->execute($input);
        return $commandTester;
    }
    
    private function getDest(){
                        $classes=array();
        $pgTables=$this->yml->getAllClassNames();
               foreach($pgTables as $ns){
                $rc=$this->main_em->getClassMetadata($ns)->getReflectionClass();
                $classes[$ns]=dirname(dirname(dirname($rc->getFileName())));
            }

            return $classes;
    }
    
    public function getYmls(){
                $paths=array();
                foreach (glob("module/*", GLOB_ONLYDIR) as $module) {
                    $path='module/' . basename($module) . '/yml/';
            if (file_exists($path)) {
                $files_in_directory = scandir($path);
                $items_count = count($files_in_directory);
                if ($items_count >= 2) {
                $paths[]='./module/' . basename($module) . '/yml/';
                }
            }
        }
        return $paths;
    }
    
}
