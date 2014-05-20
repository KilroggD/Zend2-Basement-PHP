<?php
return array(
        'service_manager' => array(
        'factories'=>array(
                    'main_navigation' => 'Navigation\Service\MainNavigationFactory', 
                    'admin_navigation' => 'Navigation\Service\AdminNavigationFactory'  
        ),
            ),
    'navigation'=>array(
        //основная навигация
      'main'=>array(
          
      ),
                  //админская навигация
       'admin'=>array(
           
           array(
            'label' => 'Пользователи',
            'route' => 'user\admin',
            'resource'=>'User\Controller\Admin',
            'privilege'=>"index",
            'pages' => array(
                array(
                   'route' => 'user\admin',
                    'action' => 'edit',
                   'privilege' => 'edit',
                ),
                            ),
        ),
         array(
            'label' => 'Роли',
            'route' => 'acl\admin\roles',
             'resource'=>'Acl\Controller\Role',
            'privilege' => 'index',
            'pages' => array(
                array(
                   'route' => 'acl\admin\roles/edit',
                    'action' => 'edit',
                     'privilege' => 'edit',
                ),
                array(
                   'route' => 'acl\admin\roles/add',
                    'action' => 'add',
                  'privilege' => 'add',
                ),
                            ),
        ),
                 array(
            'label' => 'Права доступа',
            'route' => 'acl\admin\permissions',
            'resource'=>'Acl\Controller\Permissions',
             'privilege' => 'index',
                            ),
     
                           array(
            'label' => 'Разрешения',
            'route' => 'acl\admin',
            'resource'=>'Acl\Controller\Acl',
            'privilege' => 'index',
            'pages' => array(                
                array(
                   'route' => 'acl\admin/edit',
                    'action' => 'edit',
                ),
                array(
                   'route' => 'acl\admin',
                    'action' => 'update',
                ),
                
                            ),
        ),   
     
             array(
            'label' => 'Вернуться на сайт',
            'route' => 'home'
        ),
       ),
           ),
);