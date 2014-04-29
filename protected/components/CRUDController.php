<?php
/**
 * Grundimplementierung für alle Controller dessen Seiten
 * Create Read Update und Delete enthalten
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
abstract class CRUDController extends Controller
{
	protected $model = null;
	
	/**
	 * 
	 * @param string $name
	 * @return CActiveRecord
	 */
	public function getModel($name = '')
	{
		if($this->model === null)
		{
			$this->model = $this->findModel($name);
			if($this->model === null)
				throw new CHttpException(500, MsgPicker::msg()->getMessage('EXCEPTION_'.strtoupper($this->getModelName()).'_NOTFOUND'));
		}
		
		return $this->model;
	}
	
	public abstract function findModel($name);
		
	/**
	 * @return string
	 */
	public abstract function getModelName();
	
	public abstract function actionIndex();
	
	public function actionRead($name, $edit = false)
	{
		$model = $this->getModel($name);
				
		$editable = Yii::app()->user->checkAccess('edit'.$this->getModelName());
		
		if(! $editable)
			$this->testMoadelRead($model);
		
		$params = CMap::mergeArray(
			array('model'=>$model, 'editable'=>$editable, 'edit'=>$edit),
			$this->getParamsRead()
		);
		
		$this->render(strtolower($this->getModelName()), $params);
	}
	
	protected abstract function getParamsRead();
	
	protected abstract function testMoadelRead(CActiveRecord $model);
	
	public function actionEdit($name)
	{
		$this->checkAccess('edit'.$this->getModelName());
		
		$this->actionRead($name, true);
	}
	
	public function actionCreate()
	{
		$this->editForm(true);	
	}
	
	public function actionUpdate($name)
	{
		$this->editForm(false, $name);
	}
	
	private function editForm($create, $name = '')
	{
		$modelName = $this->getModelName();
		$formName = strtolower($modelName);
		
		$class = new ReflectionClass($this->getModelName());
		if($create)
		{
			$model = $class->newInstanceArgs(array('create'));
			$url = $this->getCreateUrl();
			$modelCheck = new ModelCheck($model, $modelName, 'create'.$modelName, $formName);
			$questionID = 'QUESTION_EXIT_'.strtoupper($this->getModelName()).'CREATE';
		}
		else 
		{
			$model = $class->newInstanceArgs(array('update'));
			$url = $this->getUpdateUrl($name);
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
				$error = $this->modelCreate($model);
			}
			else
				$error = $this->modelUpdate($model, $this->getModel($name));
		}
		
		if($create)
			$button = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CREATE), array('onclick'=>"submitForm('modal', '$formName-form', '$url')"));
		else
		{
			if (! isset($_POST[$this->getModelName()]))
				$model = $this->getModel($name);
			$button = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array('onclick'=>"submitForm('modal', '$formName-form', '$url')"));
		}
		
		$urlExit = Yii::app()->createAbsoluteUrl('site/question', array(
			'head'=>MSG::HEAD_QUESTION_REALYCLOSE,
			'question'=>$questionID,
		));
		$json = json_encode(array('buttons'=>array(
			MSG::BTN_YES => "$('#modal').modal('hide'); $('#modalmsg').modal('hide');",
			MSG::BTN_NO => "$('#modalmsg').modal('hide');",
		)));
		
		$content['header'] = MsgPicker::msg()->getMessage(MSG::HEAD_SITE_CREATE);
		$content['body'] = $error . $this->renderPartial('_edit', array('model'=>$model, 'url'=>$url), true);
		$content['footer'] =
			BSHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick'=>"showModalAjax('modalmsg', '".$urlExit."', $json);")).
			$button;
		
		echo json_encode($content);
	}
	
	protected abstract function getCreateUrl();
	
	protected abstract function getUpdateUrl($name);
		
	/**
	 * 
	 * @param CActiveRecord $model
	 * @return string Error
	 */
	protected abstract function modelCreate(CActiveRecord $model);
	
	/**
	 * 
	 * @param CActiveRecord $model
	 * @param CActiveRecord $dbModel
	 * @return string Error
	 */
	protected abstract function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel);
	
	public function actionDelete($name)
	{
		$this->checkAccess('delete'.$this->getModelName());
		$this->modelDelete($this->findModel($name));
	}
	
	protected abstract function modelDelete(CActiveRecord $model);
}