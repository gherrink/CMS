<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../framework/yiit.php';

if(defined('TEST_ON_TRAVIS'))
	$config=dirname(__FILE__).'/../config/travis.php';
else
{
	$config=dirname(__FILE__).'/../config/test.php';
    require_once(dirname(__FILE__).'/WebTestCase.php');
}
require_once($yiit);


Yii::createWebApplication($config);