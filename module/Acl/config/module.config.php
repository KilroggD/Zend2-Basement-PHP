<?php
/**
 * Конфигурация модуля
 */
return array(
        'controllers' => array(
        'invokables' => array(
            'Acl\Controller\Admin' => 'Acl\Controller\AdminController'
             ),
    ),
               'doctrine' => array(
        'driver' => array(
            'Acl_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Acl/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'Acl\Entity' =>  'Acl_driver'
                ),
            ),
        ),
                   ),
    "service_manager"=>array(
        'factories' => array(
        "aclService"=>function($sm){
            $service=new Acl\Service\AclService($sm);
            return $service;
        }
        )
    ),
                    'router' => array(
        'routes' => array(
            'acl\admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/acl',
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Admin',
                        'action' => 'index',
                        'description'=>'Доступ к странице управления разрешениями',
                        'group'=>'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'modules' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/modules',
                            'defaults' => array(
                                'action' => 'modules',
                                'description'=>'Обновление разрешений в БД',
                                'group'=>'admin'
                            ),
                        ),
                    ),
                ),
            ),
            ),
                        ),
);