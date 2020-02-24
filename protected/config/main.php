<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Queue',
    'theme' => 'classic',
    'sourceLanguage' => 'en',
    'preload' => array('log'),
    'import'         => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*'
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'password',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'api'
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // 'errorAction' => YII_DEBUG ? null : 'site/error',
            'errorAction' =>  'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'webmaster@example.com',
    ),
);
