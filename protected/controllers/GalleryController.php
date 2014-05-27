<?php
class GalleryController extends CRUDController implements CRUDReadModels
{
	
	public function actionIndex()
	{
		$this->actionRead('');
	}
	
	public function getReadModels($name, $editLng)
	{
		if($name === '' || $name === null || $name === 'index')
			return GalleryView::model()->findAll("parent_label IS NULL AND languageid = '$editLng'");
		else
			return GalleryView::model()->findAllByAttributes(array('languageid'=>$editLng, 'parent_label'=>$name));
	}
	
	public function findModel($name, $editLng)
	{
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