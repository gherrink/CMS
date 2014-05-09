<?php
/**
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class SiteController extends CRUDController
{
	
	/**
	 *
	 * @param string $name
	 * @param string $editLng
	 * @return CActiveRecord
	 */
	public function findModel($name = '', $editLng = '')
	{
		return Site::model()->findByAttributes(array('label'=>$name));
	}
	
	/**
	 * @return string
	*/
	public function getModelName()
	{
		return 'Site';
	}
	
	protected function getParamsRead()
	{
		return array('layout'=>$this->getModel()->layout);
	}
	
	protected function testMoadelRead(CActiveRecord $model)
	{
		$sql = "SELECT COUNT(*) FROM SiteContentView WHERE siteid = '{$model->siteid}' AND languageid = '".Yii::app()->language."' AND {$this->getRoleaccessSQLWhere()}";
		if(SiteContentView::model()->countBySql($sql) <= 0)
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOCONTENT));
		
		return true;
	}
	
	/**
	 *
	 * @param CActiveRecord $model
	 * @return string Error
	 */
	protected function modelCreate(CActiveRecord $model)
	{
		$model->siteid = Yii::app()->keygen->getUniquKey();
		$model->layout = strtolower($model->layout);
		
		$transaktion = Yii::app()->db->beginTransaction();
		if($model->insert() && $this->createSiteHeader($model))
			try
			{
				$transaktion->commit();
				$content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$model->label));
				echo json_encode($content);
				Yii::app()->end();
			}
			catch (Exception $e)
			{}
		
		$transaktion->rollBack();
	}
	
	private function createSiteHeader(Site $site)
	{
		if(! isset($_POST['SiteLanguage']))
			return true;
	
		foreach ($_POST['SiteLanguage'] as $siteAttributes)
		{
			$siteLangauge = new SiteLanguage();
			$siteLangauge->attributes = $siteAttributes;
			$siteLangauge->siteid = $site->siteid;
			if(! $siteLangauge->insert())
				return false;
		}
	
		return true;
	}
	
	/**
	 *
	 * @param CActiveRecord $model
	 * @param CActiveRecord $dbModel
	 * @return string Error
	*/
	protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
	{	
		$dbModel->layout = strtolower($model->layout);
		$dbModel->roleaccess = $model->roleaccess;
		$dbModel->label = $model->label;
		
		$transaktion = Yii::app()->db->beginTransaction();
		if($dbModel->update() && $this->updateSiteHeader($dbModel))
			try
			{
				$content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$dbModel->label));
				echo json_encode($content);
				Yii::app()->end();
			}
			catch (Exception $e)
			{}
				
		$transaktion->rollBack();
		return BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage(MSG::ERROR_SITE_NOTUPDATE)); 
	}
	
	private function updateSiteHeader(Site $site)
	{
		if(! isset($_POST['SiteLanguage']))
			return true;
	
		foreach ($_POST['SiteLanguage'] as $siteAttributes)
		{
			$siteLangauge = new SiteLanguage();
			$siteLangauge->attributes = $siteAttributes;
			$siteLanguageDB = SiteLanguage::model()->findByAttributes(array('siteid'=>$site->siteid, 'languageid'=>$siteLangauge->languageid));
			if($siteLanguageDB === null)
			{
				$siteLangauge->siteid = $site->siteid;
				if(! $siteLangauge->insert())
					return false;
			}
			else
			{
				$siteLanguageDB->head = $siteLangauge->head;
				if(! $siteLanguageDB->update())
					return false;
			}
		}
	
		return true;
	}
	
	protected function modelDelete(CActiveRecord $model)
	{
		if($model->delete())
		{
			echo json_encode(array('success'=>Yii::app()->createAbsoluteUrl('site')));
			Yii::app()->end();
		}
	}
	
	/**
	 * This is the default 'index' action that renders
	 * the Homepage.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/**
	 * Add new Site header language
	 * @param string $lng
	 * @param int $counter
	 */
	public function actionNewLanguage($lng, $counter)
	{
		$this->checkAccess('addSiteNewLanguage');
	
		$siteLanguage = new SiteLanguage();
		$siteLanguage->languageid = $language;
		$this->renderPartial('_language', array('counter'=>$counter, 'model'=>$siteLanguage, 'form'=> new BsActiveForm()));
	}
	
	/**
	 * Delete Site header language
	 * @param string $name
	 * @param string $language
	 * @throws CHttpException
	 */
	public function actionDeleteLanguage($name, $lng)
	{
		$this->checkAccess('deleteSiteLanguage');
	
		if(! SiteLanguage::model()->deleteAllByAttributes(array('siteid'=>$name, 'languageid'=>$language)))
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_LANGUAGENOTDELETE));
	}
	
	/**
	 * Delets content form site
	 * @param unknown $site
	 * @param unknown $con
	 * @param unknown $lng
	 * @throws CHttpException
	 */
	public function actionDeleteContent($site, $con, $lng)
	{
		$siteCon = SiteContent::model()->findByAttributes(array('siteid'=>$site, 'languageid'=>$lng, 'contentid'=>$con));
		
		if($siteCon === null)
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND));
		
		$pos = $siteCon->position;
		$siteLable = $siteCon->site->label;
		
		$transaktion = Yii::app()->db->beginTransaction();
		if($siteCon->delete() && $this->moveContentPos($site, $lng, 'position > '.$pos, -1))
			try
			{
				$transaktion->commit();
				$content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$siteLable));
				echo json_encode($content);
				Yii::app()->end();
			}
			catch (Exception $e)
			{}
		
			$transaktion->rollBack();
	}
	
	private function moveContentPos($site, $lng, $sqlPos, $move)
	{
		$siteContents = SiteContent::model()->findAll("siteid='$site' AND languageid='$lng' AND ". $sqlPos);
		foreach ($siteContents as $siteContent)
		{
			$siteContent->position = $siteContent->position + $move;
			if(! $siteContent->update())
				return false;
		}
		
		return true;
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}