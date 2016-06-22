<?php

/**
 * Конфигурация модуля
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Acl\Controller\Acl' => 'Acl\Controller\AclController',
            'Acl\Controller\Permissions' => 'Acl\Controller\PermissionsController',
            'Acl\Controller\Role' => 'Acl\Controller\RoleController',
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
                    'Acl\Entity' => 'Acl_driver'
                ),
            ),
        ),
    ),
    "service_manager" => array(
        'factories' => array(
            "aclService" => function($sm) {
                $service = new Acl\Service\AclService($sm);
                return $service;
            }
        )
    ),
    'form_elements' => array(
        'factories' => array(
            'Acl\Form\AclForm' => function() {
                $form = new \Acl\Form\AclForm();
                $form->setInputFilter(new \Acl\Form\AclFilter());
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
                return $form;
            },
            'Acl\Form\RoleForm' => function() {
                $form = new \Acl\Form\RoleForm();
                $form->setInputFilter(new \Acl\Form\RoleFilter);
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
                return $form;
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
                        'controller' => 'Acl\Controller\Acl',
                        'action' => 'index',
                        'description' => 'Доступ к странице управления разрешениями',
                        'group' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'update' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => "/update[/:flag]",
                            'defaults' => array(
                                'action' => 'update',
                                'description' => 'Обновление разрешений в БД',
                                'group' => 'admin'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'defaults' => array(
                                'action' => 'edit',
                                'description' => 'Редактирование свойств разрешения',
                                'group' => 'admin'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                                'description' => 'Удаление разрешения из БД',
                                'group' => 'admin'
                            ),
                        ),
                    )
                ),
            ),
            'acl\admin\permissions' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/permissions',
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Permissions',
                        'action' => 'index',
                        'description' => 'Доступ к странице изменений прав ролей',
                        'group' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'save' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/save',
                            'defaults' => array(
                                'action' => 'save',
                                'description' => 'Изменение разрешений ролей',
                                'group' => 'admin'
                            ),
                        ),
                    ),
                ),
            ),
            'acl\admin\roles' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/roles',
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Role',
                        'action' => 'index',
                        'description' => 'Доступ к странице управления ролями',
                        'group' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/add[/:id]',
                            'defaults' => array(
                                'action' => 'add',
                                'description' => 'Создание ролей',
                                'group' => 'admin'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'defaults' => array(
                                'action' => 'edit',
                                'description' => 'Редактирование ролей',
                                'group' => 'admin'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                                'description' => 'Удаление ролей',
                                'group' => 'admin'
                            ),
                        ),
                    )
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index' => __DIR__ . '/../../Application/view/error/index.phtml',
            'acl/acl/update' => __DIR__ . '/../view/acl/update.phtml',
            'acl/acl/index' => __DIR__ . '/../view/acl/index.phtml',
            'acl/acl/edit' => __DIR__ . '/../view/acl/edit.phtml',
            'acl/role/index' => __DIR__ . '/../view/role/index.phtml',
            'acl/role/edit' => __DIR__ . '/../view/role/edit.phtml',
            'acl/permissions/index' => __DIR__ . '/../view/permissions/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'aclList' => 'Acl\View\Helper\AclListHelper',
            'Allowed' => 'Acl\View\Helper\AllowedHelper',
        ),
    ),
);
