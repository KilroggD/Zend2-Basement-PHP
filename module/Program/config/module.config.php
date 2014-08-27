<?php
return array(
        'doctrine' => array(
        
        'driver' => array(
            'Program_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Program/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'Program\Entity' =>  'Program_driver'
                ),
            ),
        ),
    ),   
);