<?php
/**
 * Grundimplementierung für alle Controller dessen Seiten
 * Create Read Update und Delete enthalten
 * 
 * Für den Controller müssen folgende Rechte angelegt werden:
 *  - edit{modelName}
 *  - create{modelName}
 *  - update{modelName}
 *  - delete{modelName}
 *  
 * Im Controller müssen folgende Methoden implementiert werden:
 *  - public function getModelName();
 *  - public function findModel($name);
 *  - protected function getParamsRead();
 *  - protected function testMoadelRead(CActiveRecord $model);
 *  - protected function modelCreate(CActiveRecord $model);
 *  - protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel);
 *  
 * Für den Controller müssen folgende Views erstellt werden:
 *  - {modelName}
 *  - _edit
 *  
 * Das Model für den Controller muss folgende Attribute enthalten:
 *  - eine eindeutige ID
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
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */

abstract class CRUDController extends Controller
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
		if($this->model === null)
		{
			$this->model = $this->findModel($name, $editLng);
			if($this->model === null)
				throw new CHttpException(500, MsgPicker::msg()->getMessage('EXCEPTION_'.strtoupper($this->getModelName()).'_NOTFOUND'));
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
		if($editLng !== '')
		{
			if(! MsgPicker::isAvailable($editLng) ||
			! Language::isLanguageActive($editLng))
			{
				$editLng = Yii::app()->language;
			}
		}
		
		$model = $this->getModel($name, $editLng);
				
		$editable = Yii::app()->user->checkAccess('edit'.$this->getModelName());
		
		if(! $editable)
			$this->testMoadelRead($model);
		
		$params = CMap::mergeArray(
			array('model'=>$model, 'editable'=>$editable, 'edit'=>$edit, 'editLng'=>$editLng),
			$this->getParamsRead()
		);
		
		$this->render(strtolower($this->getModelName()), $params);
	}
	
	/**
	 * Giving additional Parameter for the view.
	 */
	protected abstract function getParamsRead();
	
	/**
	 * Test if the model can be displeyed for the user don't effects
	 * the displey of the edit-mode
	 * @param CActiveRecord $model
	 */
	protected abstract function testMoadelRead(CActiveRecord $model);
	
	/**
	 * Action to view the edit-mode of the Model
	 * @param string $name
	 */
	public function actionEdit($name, $editLng = '')
	{
		$this->checkAccess('edit'.$this->getModelName());
		
		$this->actionRead($name, true, $editLng);
	}
	
	/**
	 * Action to create a new Model.
	 */
	public function actionCreate()
	{
		$this->editForm(true);	
	}
	
	/**
	 * Update action to update a Model with the $name.
	 * @param string $name
	 */
	public function actionUpdate($name)
	{
		$this->editForm(false, $name);
	}
	
	/**
	 * Create the Data for the Modal to create or update a Model.
	 * @param boolean $create
	 * @param string $name
	 */
	private function editForm($create, $name = '')
	{
		$modelName = $this->getModelName();
		$formName = strtolower($modelName);
		
		$class = new ReflectionClass($this->getModelName());
		if($create)
		{
			$model = $class->newInstanceArgs(array('create'));
			$url = Yii::app()->createAbsoluteUrl(strtolower($this->getModelName()).'/create');
			$modelCheck = new ModelCheck($model, $modelName, 'create'.$modelName, $formName);
			$questionID = 'QUESTION_EXIT_'.strtoupper($this->getModelName()).'CREATE';
		}
		else 
		{
			$model = $class->newInstanceArgs(array('update'));
			$url = Yii::app()->createAbsoluteUrl(strtolower($this->getModelName()).'/update', array('name'=>$name));
			$modelCheck = new ModelCheck($model, $modelName, 'update'.$modelName, $formName);
			$questionID = 'QUESTION_EXIT_'.strtoupper($this->getModelName()).'UPDATE';
		}
		
		$error = '';
		
		if($this->checkModel($modelCheck))
		{
			$model->update_userid = Yii::app()->user->getID();
			$model->update_time = date('Y-m-d H:i:s', time());
			
			if($create)
			{
				$model->create_userid = Yii::app()->user->getID();
				$model->create_time = date('Y-m-d H:i:s', time());
				$this->modelCreate($model);
				$error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage('ERROR_'.strtoupper($this->getModelName()).'_NOTCREATE'));
			}
			else
			{
				$this->modelUpdate($model, $this->getModel($name));
				$error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage('ERROR_'.strtoupper($this->getModelName()).'_NOTUPDATE'));
			}
		}
		
		if($create)
		{
			$button = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CREATE), array('onclick'=>"cmsSubmitForm('modal', '$formName-form', '$url')"));
			$head = MsgPicker::msg()->getMessage('HEAD_'.strtoupper($this->getModelName()).'_CREATE');
		}
		else
		{
			if (! isset($_POST[$this->getModelName()]))
				$model = $this->getModel($name);
			$button = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array('onclick'=>"cmsSubmitForm('modal', '$formName-form', '$url')"));
			$head = MsgPicker::msg()->getMessage('HEAD_'.strtoupper($this->getModelName()).'_UPDATE');
		}
		
		$urlExit = Yii::app()->createAbsoluteUrl('site/question', array(
			'head'=>MSG::HEAD_QUESTION_REALYCLOSE,
			'question'=>$questionID,
		));
		$json = json_encode(array('buttons'=>array(
			MSG::BTN_YES => "$('#modal').modal('hide'); $('#modalmsg').modal('hide');",
			MSG::BTN_NO => "$('#modalmsg').modal('hide');",
		)));
		
		$content['header'] = $head;
		$content['body'] = $error . $this->renderPartial('_edit', array('model'=>$model, 'url'=>$url), true);
		$content['footer'] =
			BSHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick'=>"cmsShowModalAjax('modalmsg', '".$urlExit."', $json);")).
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
	public function actionDelete($name)
	{
		$this->checkAccess('delete'.$this->getModelName());
		$this->modelDelete($this->findModel($name));
		throw new CHttpException(500, MsgPicker::msg()->getMessage('EXCEPTION_'.strtoupper($this->getModelName()).'_NOTDELETE'));
	}
	
	protected abstract function modelDelete(CActiveRecord $model);
}