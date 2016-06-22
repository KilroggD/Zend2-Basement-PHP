<?php

return array(
    'router' => array(
        'routes' => array(
            'register' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        'controller' => 'User\Controller\Register',
                        'action' => 'register',
                        'description' => 'Регистрация',
                        'group' => "user",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'activate' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/activate/:uid/:token',
                            'defaults' => array(
                                'action' => 'activate',
                                'description' => 'Активация учетной записи',
                                'group' => "user",
                            ),
                        ),
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action' => 'login',
                        'description' => 'Вход на страницу логина',
                        'group' => "login",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'action' => 'authenticate',
                                'description' => 'Авторизация пользователя',
                            ),
                        ),
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action' => 'logout',
                        'description' => 'Выход из учетной записи',
                        'group' => "user",
                    ),
                ),
            ),
            'password' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/password',
                    'defaults' => array(
                        'controller' => 'User\Controller\Password',
                        'action' => 'sendpass',
                        'description' => 'Доступ к форме "Забыл пароль"',
                        'group' => "user",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'new' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/new/:uid/:token',
                            'defaults' => array(
                                'action' => 'new',
                                'description' => 'Восстановление пароля по ссылке',
                                'group' => "user",
                            ),
                        ),
                    ),
                ),
            ),
            "profile" => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/profile',
                    'defaults' => array(
                        'controller' => 'User\Controller\Profile',
                        'action' => 'index',
                        'description' => 'Просмотр своего профайла',
                        'group' => "user",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'edit' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/edit',
                            'defaults' => array(
                                'action' => 'edit',
                                'description' => 'Редактирование своего профайла',
                                'group' => "user",
                            ),
                        ),
                    ),
                ),
            ),
            "user\admin" => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin/users',
                    'defaults' => array(
                        'controller' => 'User\Controller\Admin',
                        'action' => 'index',
                        'description' => 'Доступ к разделу "управление пользователями"',
                        'group' => "admin",
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add',
                                'description' => 'Добавить пользователя',
                                'group' => "admin",
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'defaults' => array(
                                'action' => 'edit',
                                'description' => 'Редактирование профиля любого пользователя',
                                'group' => "admin",
                            ),
                        ),
                    ),
                    'toadmin' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/toadmin/:id',
                            'defaults' => array(
                                'action' => 'toadmin',
                                'description' => 'Предоставление пользователю прав системного администратора',
                                'group' => "admin",
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                                'description' => 'Удаление любого пользователя',
                                'group' => "admin",
                            ),
                        ),
                    ),
                    'group' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/group',
                            'defaults' => array(
                                'action' => 'group',
                                'description' => 'Групповые операции с пользователями',
                                'group' => "admin",
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
            'User\Controller\Profile' => 'User\Controller\ProfileController',
            'User\Controller\Admin' => 'User\Controller\AdminController',
            'User\Controller\Register' => 'User\Controller\RegistrationController'
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Paginator' => 'Application\Controller\Plugin\PaginatorPlugin',
            'Hydrator' => 'Application\Controller\Plugin\HydratorPlugin',
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'userSession' => function() {
                $sessionService = new \User\Service\SessionService();
                return $sessionService->getSessionContainer();
            },
            'userStorage' => function() {
                return new \User\Storage\UserStorage();
            },
            'authService' => function($serviceManager) {
                $authService = $serviceManager->get('doctrine.authenticationservice.orm_default');
                return $authService;
            },
            'tokenService' => function() {
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
    'form_elements' => array(
        'factories' => array(
            //формы
            'User\Form\LoginForm' => function() {
                $form = new \User\Form\LoginForm();
                $form->setInputFilter(new \User\Form\LoginFilter());
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },
            'User\Form\ForgotPassword' => function() {
                $form = new \User\Form\ForgotPasswordForm();
                $form->setInputFilter(new User\Form\ForgotPasswordFilter());
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },
            'User\Form\NewPassword' => function() {
                $form = new \User\Form\NewPasswordForm();
                $form->setInputFilter(new User\Form\NewPasswordFilter());
                $form->setHydrator(new \Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },
            'User\Form\Profile' => function() {
                $form = new \User\Form\ProfileForm();
                $form->setInputFilter(new User\Form\ProfileFilter());
                $form->setHydrator(new Zend\Stdlib\Hydrator\ClassMethods());
                return $form;
            },
            'User\Form\User' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $form = new \User\Form\UserForm($em);
                $form->setHydrator(new Zend\Stdlib\Hydrator\ClassMethods())->setInputFilter(new \Zend\InputFilter\InputFilter());
                $vg = array(
                    "user" => array(
                        "login",
                        "email",
                        "roles",
                        "status",
                        "profile" => array(
                            "firstName",
                            "lastName",
                            "middleName",
                            "occupation",
                            "phone"
                        ),
                    ),
                );
                $mm = $locator->get("ModuleManager");
                $modules = $mm->getModules();
                if (in_array("Organization", $modules)) {
                    // $vg["user"][]="grp";                   
                }
                $form->setValidationGroup($vg);
                return $form;
            },
                    'User\Form\NewUser' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $form = new \User\Form\UserForm($em);
                $form->setHydrator(new Zend\Stdlib\Hydrator\ClassMethods())->setInputFilter(new \Zend\InputFilter\InputFilter());
                return $form;
            },
                    'User\Form\Search' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $form = new \User\Form\SearchForm($em);
                $form->setHydrator(new Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },
                    'User\Form\Group' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $form = new \User\Form\GroupForm($em);
                $form->setHydrator(new Zend\Stdlib\Hydrator\ObjectProperty());
                return $form;
            },
                    'User\Form\Registration' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $form = new \User\Form\RegistrationForm($em);
                $form->setHydrator(new Zend\Stdlib\Hydrator\ClassMethods())->setInputFilter(new \Zend\InputFilter\InputFilter());
                $vg = array(
                    "user" => array(
                        "login",
                        "email",
                        "password",
                        "confirmpassword",
                        "profile" => array(
                            "firstName",
                            "lastName",
                            "middleName",
                            "occupation",
                            "phone"
                        ),
                    ),
                    "captcha"
                );
                $form->setValidationGroup($vg);
                return $form;
            },
                    //филдсеты
                    'ProfileFieldset' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $fs = new \User\Form\ProfileFieldset($em);
                return $fs;
            },
                    'UserFieldset' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $fs = new \User\Form\UserFieldset($em);
                $mm = $locator->get("ModuleManager");
                $modules = $mm->getModules();
                if (in_array("Organization", $modules)) {
                    $fs->addOrgField();
                }
                return $fs;
            },
                    'RoleFieldset' => function($sm) {
                $locator = $sm->getServiceLocator();
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $fs = new \User\Form\RoleFieldset($em);
                return $fs;
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
                            'User\Entity' => 'User_driver'
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
                        },),
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
                    'login/layout' => __DIR__ . '/../../Application/view/layout/layout_login.phtml',
                    'login/login' => __DIR__ . '/../view/user/login/login.phtml',
                    'password/sendpass' => __DIR__ . '/../view/user/password/sendpass.phtml',
                    'password/new' => __DIR__ . '/../view/user/password/new.phtml',
                    'password/change' => __DIR__ . '/../view/user/password/changepass.phtml',
                    'profile/index' => __DIR__ . '/../view/user/profile/index.phtml',
                    'profile/edit' => __DIR__ . '/../view/user/profile/edit.phtml',
                    'profile/profile' => __DIR__ . '/../view/user/profile/profile.phtml',
                    'profile/info' => __DIR__ . '/../view/user/profile/info.phtml',
                    'admin/edit' => __DIR__ . '/../view/user/admin/edit.phtml',
                    "registration/register" => __DIR__ . '/../view/user/registration/register.phtml',
                    "registration/activate" => __DIR__ . '/../view/user/registration/activate.phtml',
                ),
                'template_path_stack' => array(
                    __DIR__ . '/../view',
                ),
            ),
            'view_helpers' => array(
                'invokables' => array(
                    'pagination' => 'Application\View\Helper\PaginatorHelper',
                ),
            ),
        );
        