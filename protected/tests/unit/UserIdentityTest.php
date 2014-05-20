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
 * Description of UserIdentityTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class UserIdentityTest extends DbTestCase
{
    
    public $fixtures=array(
            'user'=>'User',
        );
    
    /**
     * @dataProvider providerAuthenticateWrong
     * @param type $username
     * @param type $password
     */
    public function testAuthenticateWrong($username, $password)
    {
        $testuser = new User();
        $testuser->userid = $username;
        $testuser->password = $password;
        $useridentity = new UserIdentity($testuser);
        $user = $useridentity->authenticate();
        $this->assertNotInstanceOf('User', $user, "$username cant be authenticated but he is");
        $this->assertFalse($user, "$username cant be authenticated but he is");
    }
    
    /**
     * @dataProvider providerAuthenticate
     * @param type $username
     * @param type $password
     */
    public function testAuthenticate($username, $password)
    {
        $testuser = new User();
        $testuser->userid = $username;
        $testuser->password = $password;
        $useridentity = new UserIdentity($testuser);
        $user = $useridentity->authenticate();
        $this->assertInstanceOf('User', $user, "$username cant be authenticated but he must");
    }
    
    public function providerAuthenticateWrong()
    {
        return array(
            array('nonexisting', 'SomePassword123'), //non user, non password
            array('bob123', 'WrongPassword123'), //user, non password
            array('someuser', 'Boddo123'), //nonuser, password
            array('dooo', 'Dooo123'), //user, password but not active
        );
    }
    
    public function providerAuthenticate()
    {
        return array(
            array('bob123', 'Boddo123'),
            array('fuuu', 'Fuuu123'),
        );
    }
}
