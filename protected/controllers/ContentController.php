<?php
/**
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 */
class ContentController extends CRUDController
{
	public function findModel($name)
	{
		return Content::model()->findByAttributes(array('label'=>$name));
	}
	
	public function getModelName()
	{
		return 'Content';
	}
	
	protected function getParamsRead()
	{
		return array();
	}
	
	protected function testMoadelRead(CActiveRecord $model)
	{
		return true;
	}
	
	protected function modelCreate(CActiveRecord $model)
	{
		$model->contentid = Yii::app()->keygen->getUniquKey();
		
		if($model->insert())
		{
			$url = Yii::app()->createAbsoluteUrl('content/edit', array('name'=>$model->label));
			echo json_encode(array('success'=>$url));
			Yii::app()->end();
		}
	}
	
	protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
	{
		$dbModel->roleaccess = $model->roleaccess;
		$dbModel->label = $model->label;
		$dbModel->languageid = $model->languageid;
		
		if($dbModel->update())
		{
			$url = Yii::app()->createAbsoluteUrl('content/edit', array('name'=>$dbModel->label));
			echo json_encode(array('success'=>$url));
			Yii::app()->end();
		}
	}
	
	protected function modelDelete(CActiveRecord $model)
	{
		if($model->delete())
		{
			echo json_encode(array('success'=>Yii::app()->createAbsoluteUrl('site')));
			Yii::app()->end();
		}
	}
}