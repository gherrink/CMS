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
 * Description of DbAuthManagerTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class DbAuthManagerTest extends CTestCase
{
    
    /**
     * @dataProvider providerRoles
     * @param type $function
     */
    public function testRoles($function)
    {
        $roles = call_user_func("DbAuthManager::$function");
        $this->assertTrue(is_array($roles), "$function must return an array");
    }
    
    /**
     * @dataProvider providerDefaults
     * @param type $function
     * @param type $default
     */
    public function testDefaults($function, $default)
    {
        $this->assertEquals($default, call_user_func("DbAuthManager::$function"));
    }
    
    public function providerRoles()
    {
        return array(
            array('getRolesSite'),
            array('getRolesGallery'),
            array('getRolesMenu'),
            array('getRolesNews'),
        );
    }
    
    public function providerDefaults()
    {
        return array(
            array('getDefaultMenuRole', MSG::MMENU),
            array('getDefaultSiteRole', MSG::MSITE),
            array('getDefaultGalleryRole', MSG::MGALLERY),
            array('getDefaultNewsRole', MSG::MNEWS),
        );
    }
}
