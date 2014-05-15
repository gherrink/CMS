<?php

/*
 * Copyright (C) 2014 Maurice Busch <busch.maurice@gmx.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of RightTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
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