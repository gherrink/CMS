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
 * Description of ViewController
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class ViewController extends QuestionController
{
    protected $view = "../_view";
    protected $viewid = 'view-table';
    protected $viewColumns = array(
        'label',
        array(
            'name' => 'roleaccess',
            'type' => 'raw',
            'value' => 'MsgPicker::msg()->getMessage($data->roleaccess)',
        ),
    );
    protected $rowExpression = '["id" => $data->label]';
    protected $selectableRows = 1;
    
    /**
     * echos json-data for a View over all Models in DB
     */
    public function actionView($head)
    {
        Yii::app()->clientscript->scriptMap['jquery.js'] = false;

        $mname = $this->getModelName();
        $model = new $mname('search');
        $model->unsetAttributes();

        $view['header'] = MsgPicker::msg()->getMessage($head);
        $view['body'] = $this->renderPartial($this->view, array('model' => $model), true, true);
        $view['footer'] = $this->createButtonFooter();

        echo json_encode($view);
    }

    /**
     * Updates the View
     */
    public function actionViewUpdate()
    {
        $mname = $this->getModelName();
        $model = new $mname('search');
        $model->unsetAttributes();
        if (isset($_GET[$mname]))
            $model->attributes = $_GET[$mname];

        $this->renderPartial($this->view, array('model' => $model));
    }

}
