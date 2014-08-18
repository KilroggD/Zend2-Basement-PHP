<?php
return array(
        'controllers' => array(
        'invokables' => array(
            'Log\Controller\Log' => 'Log\Controller\LogController'
        ),
    ),
      'doctrine' => array(


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