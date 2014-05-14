<?php
class GalleryController extends CRUDController
{
	
	public function actionIndex()
	{
		$this->render('gallery');
	}
	
	public function findModel($name, $editLng)
	{
		if($this->action->id === 'read')
		{
			if($editLng === null || $editLng === '')
				$lng = Yii::app()->language;
			else
				$lng = $editLng;
			
			if($name === '' || $name === null || $name === 'index')
				return GalleryView::model()->find("parent_label IS NULL AND languageid = '$lng'");
			else
				return GalleryView::model()->findByAttributes(array('languageid'=>$lng, 'parent_label'=>$name));
		}
		
		return Gallery::model()->findByAttributes(array('label'=>$name));
	}
	
	public function getModelName()
	{
		return 'Gallery';
	}
	
	
	/**
	 *
	 * @param CActiveRecord $model
	 * @return string Error
	*/
	protected function modelCreate(CActiveRecord $model)
	{
		
	}
	
	/**
	 *
	 * @param CActiveRecord $model
	 * @param CActiveRecord $dbModel
	 * @return string Error
	*/
	protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
	{
		
	}
	
	protected function modelDelete(CActiveRecord $model)
	{
		
	}
}