<?php
class NewsController extends CRUDController{
	
	public $defaultAction = 'news';
	
	public function actionNews(){
		
		
		$this->render('news', array('ID'=>Yii::app()->user->getID()));
		
	}
	
	public function findModel($name)
	{
		return News::model()->findByAttributes(array('label'=>$name));
	}
	
	public function getModelName()
	{
		return 'News';
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
		$model->newsid = Yii::app()->keygen->getUniquKey();
	
		if($model->insert())
		{
			$url = Yii::app()->createAbsoluteUrl('news/edit', array('name'=>$model->label));
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
			$url = Yii::app()->createAbsoluteUrl('news/edit', array('name'=>$dbModel->label));
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