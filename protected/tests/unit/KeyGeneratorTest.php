<?php

/**
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */

class KeyGeneratorTest extends CDbTestCase
{
	private $gen;
	
// 	public function __construct()
// 	{
		
// // 		Yii::app()->db = $connection;
// 		$this->gen = Yii::app()->keygen;
// 	}
	
	public function testGetPasswordKey()
	{
		$db = Yii::app()->db;
// 		echo $db->createUrl('site/site', array('bla'=>'bal'));
		
// 		$url = Yii::app()->urlManeger;
// 		$this->assertTrue(! ($url === null));
		
// 		$db = Yii::app()->db;
// 		$pwKeys = array();
// 		foreach ($this->dataUser() as $usrData)
// 		{
// 			$user = new User();
// 			$user->userid = $usrData[0];
// 			$user->password = $usrData[1];
// 			$key = $gen->getPasswordKey($user);
// 			$this->assertTrue(! array_key_exists($key, $pwKeys));
// 			$pwKeys[$key] = 1;
// 		}
	}
	
	public function dataUser()
	{
		return array(
			array('bob', '1234'),
			array('doo', '1234'),
		);
	}
	
	public function testGetMailKey()
	{
// 	public function getMailKey($mail)
// 	{
// 		return hash('sha256', $this->userKey.$mail);
// 	}
	}
	
	public function testGetUniquKey()
	{
// 	public function getUniquKey()
// 	{
// 		return md5(uniqid(rand(), TRUE));
// 	}
	}
}