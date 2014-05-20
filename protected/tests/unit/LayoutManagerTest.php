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
 * Description of LayoutManagerTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class LayoutManagerTest extends TestCase
{
    public function testGetLayouts()
    {
        $layouts = LayoutManager::getLayouts();
        $this->assertTrue(is_array($layouts), 'getLayouts must return an array');
    }
    
    public function testGetDefaultLayout()
    {
        $layout = LayoutManager::getDefaultLayout();
        $this->assertTrue(is_string($layout), 'getDefaultLayout must return a string');
    }
}
