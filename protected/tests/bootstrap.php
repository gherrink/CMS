<?php

// change the following paths if necessary
$yiit = dirname(__FILE__) . '/../../framework/yiit.php';
require_once($yiit);

if (defined('TEST_ON_TRAVIS'))
    $config = dirname(__FILE__) . '/../config/travis.php';
else
    $config = dirname(__FILE__) . '/../config/test.php';

Yii::createWebApplication($config);

if (!defined('TEST_ON_TRAVIS'))
    require_once(dirname(__FILE__) . '/WebTestCase.php');
