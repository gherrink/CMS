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
 * Description of ContactFormTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class ContactFormTest extends TestCase
{
    public function testRules()
    {
        $contact = new ContactForm();
        $rules = $contact->rules();
        $this->assertTrue(is_array($rules), "Rules must be an array");
    }
    
    public function testLables()
    {
        $contact = new ContactForm();
        $lables = $contact->attributeLabels();
        $this->assertTrue(is_array($lables), "Lables must be an array");
    }
}
