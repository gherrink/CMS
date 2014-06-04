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
 * Description of ClientInfoTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class ClientInfoTest extends CTestCase
{
    public function testIP()
    {
        foreach ($this->providerIDs() as $id)
        {
            foreach($this->providerIPs() as $ip)
            {
                $_SERVER[$id] = $ip;
                $result = ClientInfo::getIP();
                $this->assertEquals($ip, $result, "with ID $id");
                $_SERVER[$id] = null;
            }
        }
    }
    
    public function testIPUnknown()
    {
        $ip = ClientInfo::getIP();
        $this->assertTrue(($ip === ClientInfo::UNKNOWN), "IP must be unknown!");
    }
    
    /**
     * @dataProvider providerBrowser
     */
    public function testBrowser($str, $browser, $version, $platform)
    {
        $_SERVER['HTTP_USER_AGENT'] = $str;
        $test = ClientInfo::getBrowser();
        $this->assertEquals($browser, $test['name']);
        $this->assertEquals($version, $test['version']);
        $this->assertEquals($platform, $test['platform']);
    }
    
    public function providerIDs()
    {
        return array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );
    }
    
    public function providerIPs()
    {
        return array(
            '127.0.0.1',
            '1.0.0.1',
            '192.168.178.2',
            '225.225.225.225',
        );
    }
    
    /**
     * $browser, $version, $platform
     * @return type
     */
    public function providerBrowser()
    {
        return array(
            array('Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:29.0) Gecko/20100101 Firefox/29.0', ClientInfo::MF, '29.0', ClientInfo::LINUX),
        );
    }
}
