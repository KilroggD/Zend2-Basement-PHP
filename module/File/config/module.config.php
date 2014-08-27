<?php
return array(
        'doctrine' => array(
        
        'driver' => array(
            'File_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/File/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                     'File\Entity' =>  'File_driver'
                ),
            ),
        ),
    ),   
);