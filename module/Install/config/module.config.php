<?php
return array(
        'controllers' => array(
        'invokables' => array(
            'Install\Controller\Install' => 'Install\Controller\InstallController',
           
                         ),
    ),
               'router' => array(
        'routes' => array(  
                   'install' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/install',
                    'defaults' => array(
                        'controller' => 'Install\Controller\Install',
                        'action' => 'index',
                        'description'=>'Стартовая страница инсталлятора',
                        'group'=>'install'
                    ),
                ),
                'may_terminate' => true,
                                 'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:action',
                            'constraints' => array(
                                'controller' => 'Install\Controller\Install',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
                       )
            )
                   ),
           'form_elements'=>array(
           'factories' => array(
               //формы
               'InstallForm'=>function() {
                $form = new \Install\Form\InstallForm();
                $form->setInputFilter(new \Install\Form\InstallFilter());
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },  
                    )
                    ),
    
                                'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'install/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
            'install/install/index'=>__DIR__ . '/../view/install/index.phtml',
            ),
        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
               'doctrine' => array(
        'driver' => array(
            'Install_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Install/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'Install\Entity' =>  'Install_driver'
                ),
            ),
        ),
                   )
);