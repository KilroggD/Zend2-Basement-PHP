<?php
return array(
        'controllers' => array(
        'invokables' => array(
            'Update\Controller\Update' => 'Update\Controller\UpdateController',
           
                         ),
    ),
               'router' => array(
        'routes' => array(  
                   'admin\update' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/update',
                    'defaults' => array(
                        'controller' => 'Update\Controller\Update',
                        'action' => 'index',
                        'description'=>'Обновление моделей и таблиц БД',
                        'group'=>'update'
                    ),
                ),
                'may_terminate' => true,
                                 'child_routes' => array(
                    'diff' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/diff',                            
                            'defaults' => array(                                
                                'action'     => 'diff',
                                'description'=>'Создание миграции',
                            ),
                        ),
                    ),
                   'migrate' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/migrate[/:version]',                            
                            'defaults' => array(                                
                                'action'     => 'migrate',
                                'description'=>'Осуществление миграции к выбранной версии',
                            ),
                        ),
                    ),   
                                            'delete' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/delete[/:version]',                            
                            'defaults' => array(                                
                                'action'     => 'delete',
                                'description'=>'Удаление версии',
                            ),
                        ),
                    ),   
                                                 'entity' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/entity',                            
                            'defaults' => array(                                
                                'action'     => 'entity',
                                'description'=>'Обновление моделей',
                            ),
                        ),
                    ),                   
                          
                ),
                       )
            )
                   ),
        "service_manager"=>array(
        'factories' => array(
        "MigrationService"=>function($sm){
        $em = $sm->get('doctrine.entitymanager.orm_default');
            $service=new \Update\Service\MigrationService($em);
            return $service;
        }
        )
    ),
           'form_elements'=>array(
           'factories' => array(
         
                    )
                    ),
    
                                'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
            'update/update/index'=>__DIR__ . '/../view/update/index.phtml',            
            ),
        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

);