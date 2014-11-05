<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 * version 0.13.1
 */

return array(
    
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
     'doctrine' => array(
        
            'configuration' => array(
            // Configuration for service `doctrine.configuration.orm_default` service
            'orm_default' => array(
                   
                // metadata cache instance to use. The retrieved service name will
                // be `doctrine.cache.$thisSetting`
                'metadata_cache'    => 'array',

                // DQL queries parsing cache instance to use. The retrieved service
                // name will be `doctrine.cache.$thisSetting`
                'query_cache'       => 'array',

                // ResultSet cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'result_cache'      => 'array',

                // Mapping driver instance to use. Change this only if you don't want
                // to use the default chained driver. The retrieved service name will
                // be `doctrine.driver.$thisSetting`
                'driver'            => 'orm_default',

                // Generate proxies automatically (turn off for production)
                'generate_proxies'  => true,

                // directory where proxies will be stored. By default, this is in
                // the `data` directory of your application
                'proxy_dir'         => 'data/DoctrineORMModule/Proxy',

                // namespace for generated proxy classes
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',

                // SQL filters. See http://docs.doctrine-project.org/en/latest/reference/filters.html
                'filters'           => array()
            ),
      'odm_default' => array(
                'metadata_cache'     => 'array',
//
                'driver'             => 'odm_default',
//
                'generate_proxies'   => true,
                'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',
//
                'generate_hydrators' => true,
                'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
//
                'default_db' =>'scimc',
                'filters'            => array(),  // array('filterName' => 'BSON\Filter\Class'),
//
//                'logger'             => null // 'DoctrineMongoODMModule\Logging\DebugStack'
            )
        ),

        // Metadata Mapping driver configuration
        'driver' => array(
        /*    'ApplicationYamlDriver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
                'cache' => 'array',
                'extension' => '.dcm.yml',
                'paths' => array('./yml')
            ),
            'MongoYamlDriver' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver',
                'cache' => 'array',
                'extension' => '.dcm.yml',
                'paths' => array('./yml_m')
            ),*/
            // Configuration for service `doctrine.driver.orm_default` service
            'orm_default' => array(
                // By default, the ORM module uses a driver chain. This allows multiple
                // modules to define their own entities
                'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',

                // Map of driver names to be used within this driver chain, indexed by
                // entity namespace
                'drivers' => array()
            )
        ),

        // Entity Manager instantiation settings
        'entitymanager' => array(
            // configuration for the `doctrine.entitymanager.orm_default` service
            'orm_default' => array(
                // connection instance to use. The retrieved service name will
                // be `doctrine.connection.$thisSetting`
                'connection'    => 'orm_default',

                // configuration instance to use. The retrieved service name will
                // be `doctrine.configuration.$thisSetting`
                'configuration' => 'orm_default'
            )
        ),

        'eventmanager' => array(
            // configuration for the `doctrine.eventmanager.orm_default` service
            'orm_default' => array(
                                      'subscribers' => array(

                    // pick any listeners you need
                    'Gedmo\Tree\TreeListener',
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\Sluggable\SluggableListener',
                    'Gedmo\Loggable\LoggableListener',
                    'Gedmo\Sortable\SortableListener'
                ),
                    
            )
        ),

        // collector SQL logger, used when ZendDeveloperTools and its toolbar are active
        'sql_logger_collector' => array(
            // configuration for the `doctrine.sql_logger_collector.orm_default` service
            'orm_default' => array(),
        ),

        // entity resolver configuration, allows mapping associations to interfaces
        'entity_resolver' => array(
            // configuration for the `doctrine.entity_resolver.orm_default` service
            'orm_default' => array()
        ),

        // authentication service configuration
       'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => './sql/migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'DoctrineORMModule\Migrations',
                'table'     => 'migrations',
            ),
        ),
)
  );