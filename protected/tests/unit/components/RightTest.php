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
class RightTest extends TestCase
{

    private $rights = array(
        'create', 'read', 'update', 'edit', 'delete'
    );

    public function testCRUDRights()
    {
        $errors = '';
        $path = Yii::app()->basePath . '/controllers/';

        foreach (glob($path . '*Controller.php') as $filename)
        {
            include_once $filename;
            $filename = str_replace('.php', '', $filename);
            $filename = str_replace($path, '', $filename);
            $class = new $filename($filename);
            if ($class instanceof CRUDController)
                $errors .= $this->crudControllerRights($filename, Yii::app()->authManager);
        }

        $this->assertTrue(($errors === ''), $errors);
    }

    public function crudControllerRights($filename, DbAuthManager $auth)
    {
        $errors = '';
        $className = str_replace("Controller", "", $filename);
        foreach ($this->rights as $right)
        {
            $item = $right . $className;
            $operation = $auth->getAuthItem($item);
            if ($operation == null)
                $errors .= "Missing Operation '$item'\n";
        }

        return $errors;
    }

}
