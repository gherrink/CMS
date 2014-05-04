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
		
	public function testGetPasswordKey()
	{
		$gen = Yii::app()->keygen;
		$pwKeys = array();
		foreach ($this->dataUser() as $usrData)
		{
			$user = new User();
			$user->userid = $usrData[0];
			$user->password = $usrData[1];
			$key = $gen->getPasswordKey($user);
			$this->assertTrue(! array_key_exists($key, $pwKeys));
			$pwKeys[$key] = 1;
		}
	}
	
	private function dataUser()
	{
		return array(
			array('bob', '1234'),
			array('doodu', '1234'),
			array('mrbirne', '1234'),
			array('ace', '1234'),
			array('blub', '1234')
		);
	}
	
	public function testGetMailKey()
	{
		$gen = Yii::app()->keygen;
		$mailKeys = array();
		
		foreach($this->dataFirstname() as $firstname)
		{
			foreach ($this->dataLastname() as $lastname)
			{
				foreach ($this->dataDomain() as $domain)
				{
					$key = $gen->getMailKey($firstname.".".$lastname."@".$domain);
					$this->assertTrue(! array_key_exists($key, $mailKeys));
					$mailKeys[$key] = 1;
					$key = $gen->getMailKey($firstname.$lastname."@".$domain);
					$this->assertTrue(! array_key_exists($key, $mailKeys));
					$mailKeys[$key] = 1;
				}
			}
		}
	}
	
	private function dataFirstname()
	{
		return array(
			'bob',
			'peter',
			'heinz',
			'dodu',
		);
	}
	
	private function dataLastname()
	{
		return array(
			'affe',
			'baecker',
			'doofenschmirz',
		);
	}
	
	private function dataDomain()
	{
		return array(
			'googlemail.com',
			'gmail.de',
			'gmail.com',
			'gmx.de',
			'gmx.net',
			'gmx.com',
		);
	}
	
	public function testGetUniquKey()
	{
		$gen = Yii::app()->keygen;
		$keys = array();
		for($i = 0; $i < 1000; $i++)
		{
			$key = $gen->getUniquKey();
			$this->assertTrue(! array_key_exists($key, $keys));
			$keys[$key] = 1;
		}
	}
}