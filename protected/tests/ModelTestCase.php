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
 * Description of ModelTestCase
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
abstract class ModelTestCase extends DbTestCase
{

    private $model = null;

    private function getModel()
    {
        if($this->model === null)
        {
            $name = $this->getModelName();
            $this->model = new $name();
        }
        return $this->model;
    }

    public abstract function getModelName();

    public function testTableName()
    {
        $table = $this->getModel()->tableName();
        $model = $this->getModelName();
        $this->assertTrue(($table === $model), "Table '$table' is not the same as '$model' Model");
    }
    
    public function testRules()
    {
        $rules = $this->getModel()->rules();
        $this->assertTrue(is_array($rules), "{$this->getModelName()}: Rules must be an array");
    }
    
    public function testRelations()
    {
        $relations = $this->getModel()->relations();
        $this->assertTrue(is_array($relations), "{$this->getModelName()}: Rrelation must be an array");
    }
    
    public function testLables()
    {
        $lables = $this->getModel()->attributeLabels();
        $this->assertTrue(is_array($lables), "{$this->getModelName()}: Lables must be an array");
    }
    
    public function testSearch()
    {
        $result = $this->getModel()->search();
        $this->assertInstanceOf('CActiveDataProvider', $result, 'search not an instanceof CActiveDataProvider');
    }
    
    public function testModel()
    {
        $model = $this->getModel()->model();
        $this->assertInstanceOf($this->getModelName(), $model);
    }

}
