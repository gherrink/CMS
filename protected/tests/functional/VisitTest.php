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
 * Description of VisitTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class VisitTest extends WebTestCase
{
    public function testOpen()
    {
        $this->open('');
    }
    
    public function testIrgendwas()
    {
        $this->setBrowserUrl('localhost:4445/');
        $this->open('');
        $this->open('index.php');
        $this->open('index-test.php');
        $this->open('mrbirne');
        $this->open('CMS');
        $this->open('mrbirne/CMS/');
    }
}
