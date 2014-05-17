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
 * Grundimplementierung für alle Controller dessen Seiten
 * Create Read Update und Delete enthalten
 * 
 * Für den Controller müssen folgende Rechte angelegt werden:
 *  - read{modelName}
 *  - edit{modelName}
 *  - create{modelName}
 *  - update{modelName}
 *  - delete{modelName}
 *  
 * Im Controller müssen folgende Methoden implementiert werden:
 *  - public function getModelName();
 *  - public function findModel($name, $editLng);
 *  - protected function modelCreate(CActiveRecord $model);
 *  - protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel);
 * 
 * You can implement the CRUDReadModels interface to give over an array of models
 * on the read action. For this you have to implement the function:
 *  - public function getReadModels($name, $editLng);
 *  
 * You can implement the CRUDReadCheck interface to tell the read action
 * to check before render if the $model can be displeyed, for this
 * you have to implement the method:
 *  - public function checkReadable($model, $editable);
 * 
 * You can implement the CRUDReadParams interface to tell the read action
 * to give aditional parameters for the view. For this you have to
 * implement the method:
 *  - publci function getParamsRead();
 * 
 * Für den Controller müssen folgende Views erstellt werden:
 *  - {modelName}
 *  - _edit
 *  
 * Das Model für den Controller muss folgende Attribute enthalten:
 *  - eine eindeutige ID wird als name im $params beim erstellen einer URL mitgegeben.
 *  - $roleaccess
 *  - $update_time
 *  - $update_userid
 *  - $create_time
 *  - $create_userid
 * 
 * In die Sprachdatei müssen folgende Meldungen eingefügt werden:
 *  - HEAD_{modelName}_CREATE
 *  - HEAD_{modelName}_UPDATE
 *  - QUESTION_EXIT_{modelName}CREATE
 *  - QUESTION_EXIT_{modelName}UPDATE
 *  - ERROR_{modelName}_NOTCREATE
 *  - ERROR_{modelName}_NOTUPDATE
 *  - EXCEPTION_{modelName}_NOTFOUND
 *  - EXCEPTION_{modelName}_NOTDELETE
 *  
 * Im Controller stehen folgende Actions zur Verfügung:
 *  - read($name)
 *  - edit($name)
 *  - create()
 *  - update($name)
 *  - delete($name)
 *  - view($head) In $_POST['buttons'] you have to give an array of Buttons
 *  	you want to add
 *  - viewUpdate()
 *  - question($head, $question) In $_POST['buttons'] you have to give an array of Buttons
 *  	you want to add
 * 
 * View:
 *  - The view shows a Table of the models in Database
 *  - you have to change the search() method in the model-class for search criterias
 *  - if you want your own view you have to set the variable $view to your view-name
 *  - you can set the variable $viewid to change the html-id of the view
 *  - to edit the Colums of the view change the $viewColumns variable
 *  - for setting the row id change $viewColumns
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 *
 */
abstract class CRUDController extends ViewController
{

    protected $model = null;

    /**
     * Gives back the Model.
     * @param string $name
     * @param string $editLng
     * @return CActiveRecord
     */
    public function getModel($name = '', $editLng = '')
    {
        if ($this->model === null)
        {
            $this->model = $this->findModel($name, $editLng);
            if ($this->model === null)
                throw new CHttpException(500, MsgPicker::msg()->getMessage('EXCEPTION_' . strtoupper($this->getModelName()) . '_NOTFOUND'));
        }

        return $this->model;
    }

    /**
     * Searching the Model on the Database with a unique identifire.
     * @param string $name
     * @param string $editLng
     * @return CActiveRecord
     */
    public abstract function findModel($name, $editLng);

    /**
     * Gives the modelName
     * @return string
     */
    public abstract function getModelName();

    /**
     * Action to show the view of a Model
     * @param string $name
     * @param boolean $edit
     */
    public function actionRead($name, $edit = false, $editLng = '')
    {
        $this->checkAccess('read' . $this->getModelName());

        $this->render(strtolower($this->getModelName()), $this->buildReadParams($name, $edit, $editLng));
    }

    private function buildReadParams($name, $edit, $editLng)
    {
        if ($editLng !== '')
        {
            if (MsgPicker::isAvailable($editLng) && Language::isLanguageActive($editLng))
                $params['editLng'] = $editLng;
            else
                $params['editLng'] = Yii::app()->language;
        }
        else
            $params['editLng'] = Yii::app()->language;


        if ($this instanceof CRUDReadModels)
            $params['models'] = $this->getReadModels($name, $editLng);
        else
            $params['model'] = $this->getModel($name, $editLng);

        $params = $this->buildParamsEditable($params, $edit);

        if ($this instanceof CRUDReadCheck)
            $this->checkReadable($params['model'], ($params['edit'] ||
                $params['editable']));

        if ($this instanceof CRUDReadParams)
            $params = CMap::mergeArray($params, $this->getReadParams());

        return $params;
    }

    private function buildParamsEditable($params, $edit)
    {
        $params['editable'] = Yii::app()->user->checkAccess('edit' . $this->getModelName());

        if ($params['editable'] && $edit)
        {
            $params['edit'] = true;
            $params['editable'] = false;
        }
        else
            $params['edit'] = false;

        return $params;
    }

    /**
     * Action to view the edit-mode of the Model
     * @param string $name
     */
    public function actionEdit($name, $editLng = '')
    {
        $this->checkAccess('edit' . $this->getModelName());

        $this->actionRead($name, true, $editLng);
    }

    /**
     * Action to create a new Model.
     */
    public function actionCreate()
    {
        $error = false;
        $modelName = $this->getModelName();
        $formName = strtolower($modelName);

        $class = new ReflectionClass($this->getModelName());
        $model = $class->newInstanceArgs(array('create'));
        $url = Yii::app()->createAbsoluteUrl(strtolower($modelName) . '/create');
        $modelCheck = new ModelCheck($model, $modelName, 'create' . $modelName, $formName);

        if ($this->checkModel($modelCheck))
        {
            $model->update_userid = Yii::app()->user->getID();
            $model->update_time = date('Y-m-d H:i:s', time());
            $model->create_userid = Yii::app()->user->getID();
            $model->create_time = date('Y-m-d H:i:s', time());
            $this->modelCreate($model);
            $error = true;
        }

        $this->editForm('CREATE', MSG::BTN_CREATE, $url, $error, $formName, $model);
    }

    /**
     * Update action to update a Model with the $name.
     * @param string $name
     */
    public function actionUpdate($name, $editLng = '')
    {
        $error = false;
        $modelName = $this->getModelName();
        $formName = strtolower($modelName);

        $class = new ReflectionClass($this->getModelName());


        $model = $class->newInstanceArgs(array('update'));
        $url = Yii::app()->createAbsoluteUrl(strtolower($modelName) . '/update', array(
            'name' => $name));
        $modelCheck = new ModelCheck($model, $modelName, 'update' . $modelName, $formName);

        if ($this->checkModel($modelCheck))
        {
            $model->update_userid = Yii::app()->user->getID();
            $model->update_time = date('Y-m-d H:i:s', time());
            $this->modelUpdate($model, $this->getModel($name, $editLng));
            $error = true;
        }

        if (!isset($_POST[$this->getModelName()]))
            $model = $this->getModel($name, $editLng);

        $this->editForm('UPDATE', MSG::BTN_UPDATE, $url, $error, $formName, $model);
    }

    private function editForm($action, $btnID, $actionUrl, $error, $formName, $model)
    {
        if ($error)
            $error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage('ERROR_'
                        . strtoupper($this->getModelName()) . '_NOT' . $action));
        
        $params['url'] = $actionUrl;
        if($this instanceof CRUDEditPrepareModel)
            $params['model'] = $this->prepareEditModel($model);
        else
            $params['model'] = $model;
        
        if($this instanceof CRUDEditParams)
            $params = CMap::mergeArray($params, $this->getEditParams($model));
            
        $content['header'] = MsgPicker::msg()->getMessage('HEAD_' . strtoupper($this->getModelName())
            . '_' . $action);
        $content['body'] = $error . $this->renderPartial('_edit', $params, true);
        $content['footer'] = $this->buildEditFooter($formName, $btnID, $actionUrl, $action);

        echo json_encode($content);
    }

    private function buildEditFooter($formName, $btnID, $actionUrl, $action)
    {
        $questionID = 'QUESTION_EXIT_' . strtoupper($this->getModelName()) . $action;
        $button = BsHtml::button(MsgPicker::msg()->getMessage($btnID), array(
                'onclick' => "cmsSubmitForm('modal', '$formName-form', '$actionUrl')"));

        $urlExit = Yii::app()->createAbsoluteUrl(strtolower($this->getModelName()) . '/question', array(
            'head' => MSG::HEAD_QUESTION_REALYCLOSE,
            'question' => $questionID,
        ));
        $json = json_encode(array('buttons' => array(
                MSG::BTN_YES => "$('#modal').modal('hide'); $('#modalmsg').modal('hide');",
                MSG::BTN_NO => "$('#modalmsg').modal('hide');",
        )));

        return BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array(
                'onclick' => "cmsShowModalAjax('modalmsg', '" . $urlExit . "', $json);")) .
            $button;
    }

    /**
     * Creating the Model on the DB. On success you have to json_encode an
     * array with the key success with an url whitch site shoud be displeyed and
     * the method Yii::app()->end(); have to be called. 
     * 
     * echo json_encode(array('success'=>$url));
     * Yii::app()->end();
     * 
     * @param CActiveRecord $model
     * @return string Error
     */
    protected abstract function modelCreate(CActiveRecord $model);

    /**
     * Writing the updates to the Database. On success you have to json_encode an
     * array with the key success with an url whitch site shoud be displeyed and
     * the method Yii::app()->end(); have to be called. 
     * 
     * echo json_encode(array('success'=>$url));
     * Yii::app()->end();
     * 
     * @param CActiveRecord $model
     * @param CActiveRecord $dbModel
     * @return string Error
     */
    protected abstract function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel);

    /**
     * Delete Model from the DB.On success you have to json_encode an
     * array with the key success with an url whitch site shoud be displeyed and
     * the method Yii::app()->end(); have to be called. 
     * 
     * echo json_encode(array('success'=>$url));
     * Yii::app()->end();
     * 
     * @param string $name
     */
    public function actionDelete($name, $editLng = '')
    {
        $this->checkAccess('delete' . $this->getModelName());
        $this->modelDelete($this->findModel($name, $editLng));
        throw new CHttpException(500, MsgPicker::msg()->getMessage('EXCEPTION_' . strtoupper($this->getModelName()) . '_NOTDELETE'));
    }

    /**
     * Deletes the $model from the DB
     * @param CActiveRecor $model
     */
    protected abstract function modelDelete(CActiveRecord $model);
}
