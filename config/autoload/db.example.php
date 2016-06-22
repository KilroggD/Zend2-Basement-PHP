<?php

/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 * Файл содержит локальные настройки для подключения к БД
 */
$db = array(
    'host' => 'localhost',
    'port' => '5432',
    'dbname' => 'db_psql_name',
    'user' => 'db_psql_user',
    'password' => 'db_psql_pass',
    'charset' => 'utf8'
);
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host' => $db["host"],
                    'port' => $db["port"],
                    'dbname' => $db["dbname"],
                    'user' => $db["user"],
                    'password' => $db["password"],
                    'charset' => $db["charset"],
                    'driverOptions' => array(
                        1002 => 'SET NAMES ' . $db["charset"]
                    ),
                ),
            ),
            /**
             * Подключение к Mongo-ODM
             */
            'odm_default' => array(
                'server' => 'localhost',
                'port' => '27017',
                'user' => "mongo",
                'password' => "mongo",
                'dbname' => "mongo",
                'options' => array()
            ),
        ),
    )
);
