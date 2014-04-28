<?php
return array(
       'router' => array(
        'routes' => array(
                'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action'     => 'login',
                    ),
                ),
                      'may_terminate'=>true,
                              'child_routes' => array(
                    'authenticate' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/authenticate',
                            'defaults' => array(
                                'action'     => 'authenticate',
                            ),
                                                  ),
                    ),
                ),
                ),
                    'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action'     => 'logout',
                    ),
                ),
                ),
                 'password' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/password',
                    'defaults' => array(
                        'controller' => 'User\Controller\Password',
                        'action'     => 'sendpass',
                    ),
                ),
                                     'may_terminate' => true,
                          'child_routes' => array(
                    'new' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/new/:uid/:token',
                            'defaults' => array(
                                'action'     => 'new',
                            ),
                           ),
                    ),
                               'change' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/new',
                            'defaults' => array(
                                'action'     => 'change',
                            ),
                           ),
                    ),
                                   'success' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/success',
                            'defaults' => array(
                                'action'     => 'success',
                            ),
                           ),
                    ),
                              ),
                ),
            
                        "profile"=>array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
                          'options' => array(
                    'route'    => '/profile',
                    'defaults' => array(
                        'controller' => 'User\Controller\Profile',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'edit' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/edit',
                            'defaults' => array(
                                'action'     => 'edit',
                            ),
                           ),
                    ),                
                ),
            ),
        ),
    ),    
        'controllers' => array(
        'invokables' => array(
             'User\Controller\Register' => 'User\Controller\RegistrationController',
            'User\Controller\Login' => 'User\Controller\LoginController',
             'User\Controller\Password' => 'User\Controller\PasswordController',
            'User\Controller\Profile'=>'User\Controller\ProfileController'                
        ),
    ),
        'service_manager' => array(
          'factories' => array(
          'userSession' => function() {
            $sessionService = new \User\Service\SessionService();
            return $sessionService->getSessionContainer();
        },
           'userStorage'=>function(){
            return new \User\Storage\UserStorage();
           },
          'authService'=>function($serviceManager){
                    $authService = $serviceManager->get('doctrine.authenticationservice.orm_default');
                    return $authService;
          },
                  'tokenService'=>function(){
              return new User\Service\TokenService();              
                  }
       ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
       'form_elements'=>array(
           'factories' => array(
               'User\Form\LoginForm'=>function() {
                $form = new \User\Form\LoginForm();
                $form->setInputFilter(new \User\Form\LoginFilter());
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },  
                'User\Form\ForgotPassword'=>function(){
                    $form=new \User\Form\ForgotPasswordForm();
                    $form->setInputFilter(new User\Form\ForgotPasswordFilter());
                    $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                    return $form;
                    },
                'User\Form\NewPassword'=>function(){
                    $form=new \User\Form\NewPasswordForm();
                    $form->setInputFilter(new User\Form\NewPasswordFilter());
                    $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                    return $form;
                },
                'User\Form\Profile'=>function(){
                    $form=new \User\Form\ProfileForm();
                    $form->setInputFilter(new User\Form\ProfileFilter());
                    $form->setHydrator(new Zend\Stdlib\Hydrator\ClassMethods());
                    return $form;
                },
                        ),
       ),
           'doctrine' => array(
        'driver' => array(
            'User_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/User/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'User\Entity' =>  'User_driver'
                ),
            ),
        ),
                       'authentication' => array(
            // configuration for the `doctrine.authentication.orm_default` authentication service
            'orm_default' => array(
                // name of the object manager to use. By default, the EntityManager is used
                'objectManager' => 'doctrine.entitymanager.orm_default',
                'identityClass' => 'User\Entity\Users',
                'identityProperty' => 'login',
               'credential_property' => 'password', // 'password',
               'credential_callable' => function(User\Entity\Users $user, $passwordGiven) {
                    if ($user->getPassword() == md5($passwordGiven) && $user->getStatus() == $user::ACTIVE) {
                        return true;
                    } else {
                        return false;
                    }
                },            ),
        ),
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
            'login/login'             => __DIR__ . '/../view/user/login/login.phtml',
             'password/sendpass'             => __DIR__ . '/../view/user/password/sendpass.phtml',
             'password/new'         =>  __DIR__ . '/../view/user/password/new.phtml',
            'password/change' => __DIR__ . '/../view/user/password/changepass.phtml',
            'profile/index'=>__DIR__ . '/../view/user/profile/index.phtml',
            'profile/edit'=>__DIR__ . '/../view/user/profile/edit.phtml',
            'profile/profile'=>__DIR__ . '/../view/user/profile/profile.phtml',
           'profile/info'=>__DIR__ . '/../view/user/profile/info.phtml',
            ),
        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);