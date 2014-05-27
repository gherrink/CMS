<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'CMS',
    'language' => 'de',
    'charset' => 'utf-8',
    'theme' => 'classic',
    // preloading 'log' component
    'preload' => array('log'),
    'aliases' => array(
        'bootstrap' => 'ext.bootstrap',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.db.*',
        'application.models.forms.*',
        'application.models.data.*',
        'application.components.*',
        'application.components.message.*',
        'application.components.controller.*',
        'bootstrap.behaviors.*',
        'bootstrap.helpers.*',
        'bootstrap.widgets.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'gii',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        ),
    ),
    // application components
    'components' => array(
        'mail' => array(
            'class' => 'Mailer',
            'sendMail' => false,
            'defaultMail' => 'cms@cms.de',
            'defaultName' => 'CMS',
            'contactAddress' => 'busch.maurice@gmx.net',
            'registerName' => 'CMS',
            'registerMail' => 'register@cms.de',
        ),
        'keygen' => array(
            'class' => 'KeyGenerator',
            'userKey' => 'rS§84c#2^/IY|\6%bCw!',
            'passwordKey' => '#hBR#Wk5t3%c,TP:X03<',
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => false,
            'loginUrl' => array('login/login'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'class' => 'UrlManager',
            'showScriptName' => false,
            'caseSensitive' => false,
            'rules' => array(
                //c = Controller; a = Action; 
                '<language:[a-z]{2}>/<c:\w+>/<a:\w+>/<editLng:[a-z]{2}>' => array(
                    '<c>/<a>', 'urlSuffix' => '.html'),
                '<language:[a-z]{2}>/<c:\w+>/<a:\w+>/<editLng:[a-z]{2}>/<name:[a-zA-Z0-9]*>' => array(
                    '<c>/<a>', 'urlSuffix' => '.html'),
                '<language:[a-z]{2}>/<c:\w+>/<a:\w+>/<name:[a-zA-Z0-9]*>' => array(
                    '<c>/<a>', 'urlSuffix' => '.html'),
                '<language:[a-z]{2}>/<c:\w+>/<a:\w+>' => array('<c>/<a>',
                    'urlSuffix' => '.html'),
                '<language:[a-z]{2}>/<c:\w+>' => array('<c>', 'urlSuffix' => '.html'),
                '<language:[a-z]{2}>' => '',
            ),
        ),
        'db' => array(
//            'connectionString' => 'mysql:host=localhost;dbname=cms2',
            'connectionString' => 'mysql:host=localhost;dbname=karate',
            'emulatePrepare' => true,
            'username' => 'cms',
            'password' => 'BCv4r2hrfhw4ahrc',
            'charset' => 'utf8',
        ),
        'authManager' => array(
            'class' => 'DbAuthManager',
            'connectionID' => 'db',
            'defaultRoles' => array('VISITOR', 'Guest'),
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CWebLogRoute',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
