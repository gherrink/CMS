<?php

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
 * Es können folgende Methoden überschrieben werden:
 *  - protected function testMoadelRead($model);
 *  - protected function getParamsRead();
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
 * @copyright 2014
 * @version 0.1
 *
 */
abstract class CRUDController extends Controller {

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
    protected $model = null;

    /**
     * Gives back the Model.
     * @param string $name
     * @param string $editLng
     * @return mixed
     */
    public function getModel($name = '', $editLng = '') {
        if ($this->model === null) {
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
     * @return mixed
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
    public function actionRead($name, $edit = false, $editLng = '') {
//         $this->checkAccess('read' . $this->getModelName());

        if ($editLng !== '') {
            if (!MsgPicker::isAvailable($editLng) ||
                    !Language::isLanguageActive($editLng)) {
                $editLng = Yii::app()->language;
            }
        }

        $model = $this->getModel($name, $editLng);
        
        $editable = Yii::app()->user->checkAccess('edit' . $this->getModelName());

        if (!$editable)
            $this->testMoadelRead($model);

        $params = CMap::mergeArray(
            array('model' => $model, 'editable' => $editable, 'edit' => $edit, 'editLng' => $editLng), $this->getParamsRead()
        );

        $this->render(strtolower($this->getModelName()), $params);
    }

    /**
     * Giving additional Parameter for the view.
     */
    protected function getParamsRead() {
        return array();
    }

    /**
     * Test if the model can be displeyed for the user don't effects
     * the displey of the edit-mode
     * @param $model
     */
    protected function testMoadelRead($model) {
        return true;
    }

    /**
     * Action to view the edit-mode of the Model
     * @param string $name
     */
    public function actionEdit($name, $editLng = '') {
        $this->checkAccess('edit' . $this->getModelName());

        $this->actionRead($name, true, $editLng);
    }

    /**
     * Action to create a new Model.
     */
    public function actionCreate() {
        $this->editForm(true);
    }

    /**
     * Update action to update a Model with the $name.
     * @param string $name
     */
    public function actionUpdate($name, $editLng = '') {
        $this->editForm(false, $name, $editLng);
    }

    /**
     * Create the Data for the Modal to create or update a Model.
     * @param boolean $create
     * @param string $name
     */
    private function editForm($create, $name = '', $editLng = '') {
        $modelName = $this->getModelName();
        $formName = strtolower($modelName);

        $class = new ReflectionClass($this->getModelName());
        if ($create) {
            $model = $class->newInstanceArgs(array('create'));
            $url = Yii::app()->createAbsoluteUrl(strtolower($this->getModelName()) . '/create');
            $modelCheck = new ModelCheck($model, $modelName, 'create' . $modelName, $formName);
            $questionID = 'QUESTION_EXIT_' . strtoupper($this->getModelName()) . 'CREATE';
        } else {
            $model = $class->newInstanceArgs(array('update'));
            $url = Yii::app()->createAbsoluteUrl(strtolower($this->getModelName()) . '/update', array('name' => $name));
            $modelCheck = new ModelCheck($model, $modelName, 'update' . $modelName, $formName);
            $questionID = 'QUESTION_EXIT_' . strtoupper($this->getModelName()) . 'UPDATE';
        }

        $error = '';

        if ($this->checkModel($modelCheck)) {
            $model->update_userid = Yii::app()->user->getID();
            $model->update_time = date('Y-m-d H:i:s', time());

            if ($create) {
                $model->create_userid = Yii::app()->user->getID();
                $model->create_time = date('Y-m-d H:i:s', time());
                $this->modelCreate($model);
                $error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage('ERROR_' . strtoupper($this->getModelName()) . '_NOTCREATE'));
            } else {
                $this->modelUpdate($model, $this->getModel($name, $editLng));
                $error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage('ERROR_' . strtoupper($this->getModelName()) . '_NOTUPDATE'));
            }
        }

        if ($create) {
            $button = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CREATE), array('onclick' => "cmsSubmitForm('modal', '$formName-form', '$url')"));
            $head = MsgPicker::msg()->getMessage('HEAD_' . strtoupper($this->getModelName()) . '_CREATE');
        } else {
            if (!isset($_POST[$this->getModelName()]))
                $model = $this->getModel($name, $editLng);
            $button = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array('onclick' => "cmsSubmitForm('modal', '$formName-form', '$url')"));
            $head = MsgPicker::msg()->getMessage('HEAD_' . strtoupper($this->getModelName()) . '_UPDATE');
        }

        $urlExit = Yii::app()->createAbsoluteUrl('site/question', array(
            'head' => MSG::HEAD_QUESTION_REALYCLOSE,
            'question' => $questionID,
        ));
        $json = json_encode(array('buttons' => array(
                MSG::BTN_YES => "$('#modal').modal('hide'); $('#modalmsg').modal('hide');",
                MSG::BTN_NO => "$('#modalmsg').modal('hide');",
        )));

        $content['header'] = $head;
        $content['body'] = $error . $this->renderPartial('_edit', array('model' => $model, 'url' => $url), true);
        $content['footer'] = BSHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick' => "cmsShowModalAjax('modalmsg', '" . $urlExit . "', $json);")) .
                $button;

        echo json_encode($content);
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
    public function actionDelete($name, $editLng = '') {
        $this->checkAccess('delete' . $this->getModelName());
        $this->modelDelete($this->findModel($name, $editLng));
        throw new CHttpException(500, MsgPicker::msg()->getMessage('EXCEPTION_' . strtoupper($this->getModelName()) . '_NOTDELETE'));
    }

    /**
     * Deletes the $model from the DB
     * @param CActiveRecor $model
     */
    protected abstract function modelDelete(CActiveRecord $model);

    /**
     * echos json-data for a View over all Models in DB
     */
    public function actionView($head) {
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
    public function actionViewUpdate() {
        $mname = $this->getModelName();
        $model = new $mname('search');
        $model->unsetAttributes();
        if (isset($_GET[$mname]))
            $model->attributes = $_GET[$mname];

        $this->renderPartial($this->view, array('model' => $model));
    }

    /**
     * Gives a JSON array for a Question
     * @param String $question
     */
    public function actionQuestion($head, $question) {
        $content['header'] = MsgPicker::msg()->getMessage($head);
        $content['body'] = MsgPicker::msg()->getMessage($question);
        $content['footer'] = $this->createButtonFooter();

        echo json_encode($content);
    }

    private function createButtonFooter() {
        if (in_array('buttons', $_POST))
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_NOBUTTONS));

        $html = '';
        $buttons = $_POST['buttons'];

        while (($buttonaction = current($buttons)) !== FALSE) {
            $html .= BsHtml::button(MsgPicker::msg()->getMessage(key($buttons)), array(
                        'onclick' => $buttonaction,
            ));
            next($buttons);
        }

        return $html;
    }

}
