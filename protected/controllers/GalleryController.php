<?php
class GalleryController extends CRUDController implements CRUDReadModels, CRUDEditParams
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
	
	public function getEditParams(CActiveRecord $model)
	{
		$imageurl = Yii::app()->baseUrl.'/images/default.jpg';
		if ($model->image !== null) {
			$imageurl = $model->image->url;
		}
		
		$galleryLanguages = $model->languages;
		if(count($galleryLanguages) <= 0)
		{
			foreach (Language::getActiveModelLanguages() as $language)
			{
				$galleryLanguage = new GalleryLanguage();
				$galleryLanguage->languageid = $language->languageid;
				$galleryLanguages[] = $galleryLanguage;
			}
		}
		
		return array(
			'imageurl' => $imageurl,
			'galleryLanguages' => $galleryLanguages,
		);
	}
}