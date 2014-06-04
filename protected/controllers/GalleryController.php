<?php
class GalleryController extends CRUDController implements CRUDReadModels, CRUDReadParams, CRUDEditParams, CRUDValidate
{
	private $galleryLanguages = array();
	
	public function actionIndex()
	{
		$this->actionRead('');
	}
	
	public function getReadModels($name, $editLng)
	{
		if($editLng === '')
			$editLng = Yii::app()->language;
		
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
		$model->galleryid = Yii::app()->keygen->getUniquKey();
		
		$transaktion = Yii::app()->db->beginTransaction();
		if ($model->insert() && $this->createGalleryHeader($model))
			try
			{
				$transaktion->commit();
				$content['success'] = Yii::app()->createAbsoluteUrl('gallery/edit', array(
						'name' => $model->label));
				echo json_encode($content);
				Yii::app()->end();
			}
			catch (Exception $e)
			{
				
			}
		
		$transaktion->rollBack();
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

		$selectedRole = DbAuthManager::getDefaultGalleryRole();
		if ($model->roleaccess !== null)
			$selectedRole = $model->roleaccess;
		
		$imageurl = Yii::app()->baseUrl.'/images/default.jpg';
		if ($model->image !== null) {
			$imageurl = Yii::app()->baseUrl . "/" . $model->image->url;
		}
		
		return array(
			'imageurl' => $imageurl,
			'galleryLanguages' => $this->getGalleryLanguages($model),
			'roles' => DbAuthManager::getRolesGallery(),
			'selectedRole' => $selectedRole,
		);
	}
	
	public function validateAditional(CActiveRecord $model)
	{
		$valid = true;
		
		if(! isset($_POST['GalleryLanguage']))
			return false;
		
		foreach ($_POST['GalleryLanguage'] as $galleryAttributes)
		{
			$galleryLanguage = new GalleryLanguage();
			$galleryLanguage->attributes = $galleryAttributes;
			$galleryLanguage->galleryid = $model->galleryid;
			if ($galleryLanguage->validate())
				$valid = false;
				
			$this->galleryLanguages[] = $galleryLanguage;
		}
		
		return $valid;
	}
	
	private function getGalleryLanguages(Gallery $model)
	{
		if(count($this->galleryLanguages) > 0)
			return $this->galleryLanguages;
		
		$galleryLanguages = GalleryLanguage::model()->findAllByAttributes(array('galleryid'=>$model->galleryid));
		if(count($galleryLanguages) <= 0)
		{
			foreach (Language::getActiveModelLanguages() as $language)
			{
				$galleryLanguage = new GalleryLanguage();
				$galleryLanguage->languageid = $language->languageid;
				$galleryLanguages[] = $galleryLanguage;
			}
		}
		
		return $galleryLanguages;
	}
	
	private function createGalleryHeader(Gallery $gallery)
	{
		foreach ($this->galleryLanguages as $galleryLanguage)
		{
			$galleryLanguage->galleryid = $gallery->galleryid;
			if (!$galleryLanguage->insert())
			{
				return false;
			}
		}
		return true;		 
	}
	
	public function getReadParams($name, $editLng)
	{
		$head = '';
		$model = null;
		if($name !== null && $name !== '' && $name !== 'index')
		{
			$model = $this->getModel($name, $editLng);
			$language = GalleryLanguage::model()->findByAttributes(array('galleryid'=>$model->galleryid, 'languageid'=>Yii::app()->language));
			$head = $language->head;
		}
		return array(
			'head' => $head,
			'model' => $model,
		);
	}
}