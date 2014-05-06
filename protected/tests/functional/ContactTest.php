<?php

class ContactTest extends WebTestCase
{
	
	public function testBala()
	{	
		$this->open('');
		$this->assertTextPresent('Welcome to');
	}
	
// 	public function testTest()
// 	{
// 		$this->assertTextPresent('Welcome to');
// 	}
	
}