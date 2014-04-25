<?php
return array(
               'doctrine' => array(
        'driver' => array(
            'Email_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Email/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'Email\Entity' =>  'Email_driver'
                ),
            ),
        ),
                   ),
    "service_manager"=>array(
        "emailService"=>function($sm){
            $service=new Email\Service\EmailService($sm);
            return $service;
        }
    )
);