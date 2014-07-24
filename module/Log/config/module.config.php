<?php
return array(
        'controllers' => array(
        'invokables' => array(
            'Log\Controller\Log' => 'Log\Controller\LogController'
        ),
    ),
      'doctrine' => array(
        'connection' => array(
            'odm_default' => array(
                'server'           => 'localhost',
                'port'             => '27017',
//                'connectionString' => null,
                'user'             => "rcp",
                'password'         =>  "rcp",                
                'dbname'           => "rcp",
                'options'          => array()
            ),
        ),

        'configuration' => array(
            'odm_default' => array(
                'metadata_cache'     => 'array',
//
                'driver'             => 'odm_default',
//
                'generate_proxies'   => true,
                'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',
//
                'generate_hydrators' => true,
                'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
//
                'default_db'         => "rcp",
//
                'filters'            => array(),  // array('filterName' => 'BSON\Filter\Class'),
//
//                'logger'             => null // 'DoctrineMongoODMModule\Logging\DebugStack'
            )
        ),

        'driver' => array(
            //драйверы для монго
            'Log_odm_driver' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Log/Document')
            ),
            'odm_default' => array(
                'drivers' => array(
                     'Log\Document' =>  'Log_odm_driver'
                ),
            ),
            //для постгри
            'Log_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Log/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'Log\Entity' =>  'Log_driver'
                ),
            ),
        ),

        'documentmanager' => array(
            'odm_default' => array(
           //    'connection'    => 'odm_default',
              //  'configuration' => 'odm_default',
             //   'eventmanager' => 'odm_default'
            )
        ),

        'eventmanager' => array(
            'odm_default' => array(
                'subscribers' => array()
            )
        ),
    ),
        'router' => array(
        'routes' => array(
            'log' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/log',
                    'defaults' => array(
                        'controller' => 'Log\Controller\Log',
                        'action'     => 'index',
                        'description'=>'Тест логов',
                        'group'=>'homepage',
                         'exclude'=>1
                    ),
                ),
                'may_terminate'=>true,
                         'child_routes' => array(
                           'add' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'action'     => 'add',
                                'description'=> 'Добавить лог',
                                'group'=>"admin",
                                'exclude'=>1
                            ),
                           ),
                    ),
                             )
            ),
            )
            ),
        "service_manager"=>array(
        'factories' => array(
        "logService"=>function($sm){
            $service=new Log\Service\LogService($sm);
            return $service;
        }
        )
    )
);