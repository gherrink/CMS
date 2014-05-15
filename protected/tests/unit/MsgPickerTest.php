<?php

/**
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class MsgPickerTest extends TestCase
{

    private static $CRUDCONSTS = array(
        'HEAD_###_CREATE',
        'HEAD_###_UPDATE',
        'QUESTION_EXIT_###CREATE',
        'QUESTION_EXIT_###UPDATE',
        'ERROR_###_NOTCREATE',
        'ERROR_###_NOTUPDATE',
        'EXCEPTION_###_NOTFOUND',
        'EXCEPTION_###_NOTDELETE',
    );

    public function testLangaugePackeges()
    {
        $success = true;
        $error = '';
        $languages = MsgPicker::getAvailableLanguages();
        $path = Yii::app()->basePath . '/' . MsgPicker::getMsgPath();

        foreach ($languages as $language)
        {
            if (!file_exists($path . '/' . $language . '.php'))
            {
                $error .= 'The language packet ' . $language . ' dose not exist.' . PHP_EOL;
                $success = false;
            }
        }

        $this->assertTrue($success, $error);
    }

    public function testConstants()
    {
        $success = true;
        $error = '';
        $class = new ReflectionClass('MSG');
        $consts = $class->getConstants();

        while (($str = current($consts)) !== FALSE)
        {
            if ($str !== key($consts))
            {
                $error .= 'The Constant "' . $str . '" is not equal her key "' . key($consts) . '".' . PHP_EOL;
                $success = false;
            }
            next($consts);
        }

        $this->assertTrue($success, $error);
    }

    /**
     * @depends testLangaugePackeges
     * @depends testConstants
     */
    public function testAllMsgConstsHaveArrayKeys()
    {
        $success = true;
        $error = '';

        $path = Yii::app()->basePath . '/' . MsgPicker::getMsgPath();
        $class = new ReflectionClass('MSG');
        $consts = $class->getConstants();

        foreach (MsgPicker::getAvailableLanguages() as $language)
        {
            $lngPack = include $path . '/' . $language . '.php';

            foreach ($consts as $const)
            {
                if (!array_key_exists($const, $lngPack))
                {
                    $error .= "$language missing $const\n";
                    $success = false;
                }
            }
        }

        $this->assertTrue($success, $error);
    }

    /**
     * @depends testLangaugePackeges
     * @depends testConstants
     */
    public function testAllArrayKeysHaveMsgConsts()
    {
        $success = true;
        $error = '';

        $path = Yii::app()->basePath . '/' . MsgPicker::getMsgPath();
        $class = new ReflectionClass('MSG');
        $consts = $class->getConstants();

        foreach (MsgPicker::getAvailableLanguages() as $language)
        {
            $lngPack = include $path . '/' . $language . '.php';

            while (current($lngPack) !== false)
            {
                if (!array_key_exists(key($lngPack), $consts))
                {
                    $error .= "language {$language} used " . key($lngPack) . "\n";
                    $success = false;
                }
                next($lngPack);
            }
        }

        $this->assertTrue($success, $error);
    }

    /**
     * @depends testConstants
     */
    public function testCeckGRUDControllerConsts()
    {
        $success = true;
        $error = '';

        $class = new ReflectionClass('MSG');
        $consts = $class->getConstants();

        $path = Yii::app()->basePath . '/controllers/';

        foreach (glob($path . '*Controller.php') as $filename)
        {
            include_once $filename;
            $filename = str_replace('.php', '', $filename);
            $filename = str_replace($path, '', $filename);
            $class = new $filename($filename);
            if ($class instanceof CRUDController)
            {
                $filename = str_replace('CONTROLLER', '', strtoupper($filename));
                foreach (self::$CRUDCONSTS as $crud)
                {
                    $crud = str_replace('###', $filename, $crud);
                    if (!array_key_exists($crud, $consts))
                    {
                        $error .= "CRUD const $crud missing \n";
                        $success = false;
                    }
                }
            }
        }

        $this->assertTrue($success, $error);
    }

    /**
     * @dataProvider msgProvider
     */
    public function testGetMessage($const, $param, $result)
    {
        $msg = MsgPicker::msg()->getMessage($const, $param);
        $this->assertEquals($msg, $result, "On $const no match");
    }

    public function msgProvider()
    {
        return array(
            array(
                MSG::TEST,
                array(),
                'This is a Test'),
            array(
                MSG::TEST_PARAM,
                array(
                    'par1' => 'param1',
                    'par2' => 'param2'),
                'Test with params param1 and param2'),
        );
    }

    /**
     * @depends testGetMessage
     */
    public function testMsgNotFound()
    {
        try
        {
            MsgPicker::msg()->getMessage('THIS_KEY_DOSE_NOT_EXISTS');
            $this->assertTrue(false, "this must throw an exception");
        }
        catch (Exception $e)
        {
            $this->assertTrue(true);
        }
    }

}
