<?php
return array(
     'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'=>'Admin\Controller\IndexController',
            ),
         ),
    'router' => array(
    'routes'=>array(
               'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                        'description'=>'Доступ к панели администратора',                                
                    ),
                ),
            ),
    ),
        ),
                            'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'admin/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
            'admin/index/index'=>__DIR__ . '/../view/admin/index.phtml',
            ),
        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);