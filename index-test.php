<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
//if(defined('TEST_ON_TRAVIS'))
//	$config=dirname(__FILE__).'/../config/travis.php';
//else
    $config=dirname(__FILE__).'/protected/config/travis.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
