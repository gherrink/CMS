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
 * Description of UrlManagerTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class UrlManagerTest extends TestCase
{

    /**
     * @dataProvider providerCreateUrl
     * @param type $route
     * @param type $params
     */
    public function testCreateUrl($route, $params)
    {
        $urlManager = Yii::app()->urlManager;
        $url = $urlManager->createUrl($route, $params);
        
        $routeSplit = mb_split('/', $route);
        $this->assertRegExp("*$routeSplit[0]*", $url, 'controller was not found');
        $this->assertRegExp("*$routeSplit[1]*", $url, 'action was not found');
            
        $language = false;
        foreach ($params as $key => $value)
        {
            if ($key === 'language')
            {
                $this->assertRegExp("*$value*", $url, 'language was not found');
                $language = true;
            }
            elseif ($key === 'editLng')
                $this->assertRegExp("*$value*", $url, 'edit language was not found');
            else
                $this->assertRegExp("*$key=$value*", $url, "$key with $value was not found");
        }

        if (!$language)
            $this->assertRegExp('*'.Yii::app()->language.'*', $url, 'language was not found');
    }

    public function providerCreateUrl()
    {
        return array(
            array('login/login', array()),
            array('site/site', array()),
            array('site/blaa', array('param1' => 'value1')),
            array('blub/blaa', array('param1' => 'value1', 'param2' => 'value2')),
            array('blub/daaa', array('language' => 'de')),
            array('blub/daaa', array('language' => 'de', 'param1' => 'value1')),
            array('blub/daaa', array('editLng' => 'de')),
            array('blub/daaa', array('editLng' => 'de', 'param1' => 'value1')),
            array('blub/daaa', array('editLng' => 'de', 'language' => 'de')),
            array('blub/daaa', array('editLng' => 'de', 'language' => 'de',
                    'param1' => 'value1')),
        );
    }

}
