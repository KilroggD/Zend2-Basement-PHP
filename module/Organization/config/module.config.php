<?php
return array(
            'service_manager' => array(
        'factories'=>array(                    
                    'organization_navigation' => 'Organization\Service\AdminNavigationFactory'  
        ),
            ),
      'controllers' => array(
        'invokables' => array(
            'Organization\Controller\Admin' => 'Organization\Controller\AdminController',
            'Organization\Controller\Organization'=>'Organization\Controller\OrganizationController',
            'Organization\Controller\Type'=>'Organization\Controller\TypeController',
                         ),
    ),
           'controller_plugins' => array(
        'invokables' => array(
            'Paginator' => 'Application\Controller\Plugin\PaginatorPlugin',
            'Hydrator' => 'Application\Controller\Plugin\HydratorPlugin',
        )
    ),
     'router' => array(
        'routes' => array(
                "organizations"=>array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                          'options' => array(
                    'route'    => '/organizations',
                    'defaults' => array(
                        'controller' => 'Organization\Controller\Organization',
                        'action'     => 'index',
                        'description'=> 'Просмотр списка организаций',
                        'group'=>"organization",
                    ),
                ),
                'may_terminate' => true,    
                ),            
                 "organizations\admin"=>array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
                          'options' => array(
                    'route'    => '/admin/organizations',
                    'defaults' => array(
                        'controller' => 'Organization\Controller\Admin',
                        'action'     => 'index',
                        'description'=> 'Доступ к разделу "управление организациями"',
                        'group'=>"admin",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                           'add' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'action'     => 'add',
                                'description'=> 'Добавить организацию',
                                'group'=>"admin",
                            ),
                           ),
                    ),
                    'edit' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'defaults' => array(
                                'action'     => 'edit',
                                'description'=> 'Редактирование организации',
                                'group'=>"admin",
                            ),
                           ),
                    ),
                    
                                   
                                'delete' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/delete/:id',
                            'defaults' => array(
                                'action'     => 'delete',
                                'description'=> 'Удаление организации',
                                'group'=>"admin",
                            ),
                           ),
                    ),
                              'view' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/view/:id',
                            'defaults' => array(
                                'action'     => 'view',
                                'description'=> 'Просмотр карточки организации',
                                'group'=>"admin",
                            ),
                           ),
                    ),
                ),
            ),
                           "organizations\admin\types"=>array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
                          'options' => array(
                    'route'    => '/admin/organizations/types',
                    'defaults' => array(
                        'controller' => 'Organization\Controller\Type',
                        'action'     => 'index',
                        'description'=> 'Доступ к разделу "управление типами организаций"',
                        'group'=>"admin",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                           'add' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/add[/:id]',
                            'defaults' => array(
                                'action'     => 'add',
                                'description'=> 'Добавить тип',
                                'group'=>"admin",
                            ),
                           ),
                    ),
                    'edit' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'defaults' => array(
                                'action'     => 'edit',
                                'description'=> 'Редактирование типа',
                                'group'=>"admin",
                            ),
                           ),
                    ),
                    
                                   
                                'delete' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/delete/:id',
                            'defaults' => array(
                                'action'     => 'delete',
                                'description'=> 'Удаление типа',
                                'group'=>"admin",
                            ),
                           ),
                    ),
          
                ),
            ),
            )
         ),
    'doctrine' => array(
        
        'driver' => array(
            'Organization_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Organization/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'Organization\Entity' =>  'Organization_driver'
                ),
            ),
        ),
    ),   
        'form_elements'=>array(
           'factories' => array(
               //формы
               'Organization\Form\OrgForm'=>function($sm) {
    $locator=$sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $form = new \Organization\Form\OrganizationForm($em);                
                $form->setInputFilter(new \Organization\Form\OrganizationFilter());
                $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em))
                      ->setObject(new \Organization\Entity\Organizations());;
                return $form;
            },  
                    'Organization\Form\TypeForm'=>function(){
                $form=new \Organization\Form\OrganizationTypeForm();
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
                $form->setInputFilter(new \Organization\Form\OrganizationTypeFilter());
                return $form;
                    },
                       'Organization\Form\Search'=>function($sm){                                    
                $form= new \Organization\Form\SearchForm();
                $form->setHydrator(new Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
                  },             
               
                    
                    )
                 ),
                          'navigation'=>array(
                              "main"=>array(
                                  
                              ),
                              'organization'=>array(
 array(
            'label' => 'Организации',
            'route' => 'organizations\admin',
            'resource'=>'Organization\Controller\Admin',
            'privilege' => 'index',
            'pages' => array(                
                array(
                   'route' => 'organizations\admin/add',
                    'action' => 'add',
                ),
                array(
                   'route' => 'organizations\admin/edit',
                    'action' => 'edit',
                ),              
                            ),
        ),
                                    array (
                     'label'=>'Типы организаций',
                    'route'=>"organizations\admin\types",
                    'resource'=>'Organization\Controller\Type',
                    'privilege'=>'index'                    
                )
                              )
                          ),
                          'view_manager' => array(
                                                'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',     
             'organization/admin/index'=> __DIR__ . '/../../Organization/view/admin/index.phtml',     
            'organization/admin/add'=> __DIR__ . '/../../Organization/view/admin/add.phtml',     
            'organization/admin/edit'=> __DIR__ . '/../../Organization/view/admin/edit.phtml', 
            'organization/admin/view'=> __DIR__ . '/../../Organization/view/admin/view.phtml', 
            'organization/type/index'=> __DIR__ . '/../../Organization/view/type/index.phtml',             
             'organization/type/add'=> __DIR__ . '/../../Organization/view/type/add.phtml',     
            'organization/type/edit'=> __DIR__ . '/../../Organization/view/type/edit.phtml', 
            ),
        'template_path_stack' => array(
         'organization'=> __DIR__ . '/../view',
        ),
                                                    ),
                          'view_helpers'=>array(
                                      'invokables'=>array(
                    'pagination'=>'Application\View\Helper\PaginatorHelper',  
                  ),
                          )

);