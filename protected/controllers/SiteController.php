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
	 * @return CActiveRecord
	 */
	public function findModel($name = '')
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
	}
	
	protected function getCreateUrl()
	{
		return Yii::app()->createAbsoluteUrl('site/create');
	}
	
	protected function getUpdateUrl($name)
	{
		return Yii::app()->createAbsoluteUrl('site/update', array('name'=>$name));
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
				$this->addSuccessMessage(new Message(MSG::SUCCESS_SITE_CREATE));
				$content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$model->label));
				echo json_encode($content);
				Yii::app()->end();
			}
			catch (Exception $e)
			{}
		
		$transaktion->rollBack();
		return BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage(MSG::ERROR_SITE_NOTCREATE));
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
				$transaktion->commit();
				$this->addSuccessMessage(new Message(MSG::SUCCESS_SITE_UPDATE));
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
		if(! $model->delete())
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOTDELETE));
	
		echo json_encode(array('success'=>Yii::app()->createAbsoluteUrl('site')));
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
	
	public function actionNewLanguage($language, $counter)
	{
		$this->checkAccess('addSiteNewLanguage');
	
		$siteLanguage = new SiteLanguage();
		$siteLanguage->languageid = $language;
		$this->renderPartial('_language', array('counter'=>$counter, 'model'=>$siteLanguage, 'form'=> new BsActiveForm()));
	}
	
	public function actionDeleteLanguage($name, $language)
	{
		$this->checkAccess('deleteSiteLanguage');
	
		if(! SiteLanguage::model()->deleteAllByAttributes(array('siteid'=>$name, 'languageid'=>$language)))
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_LANGUAGENOTDELETE));
	}
	
	/**
	 * Gives a JSON array for a Question
	 * @param String $question
	 */
	public function actionQuestion($head, $question)
	{
		if(in_array('buttons', $_POST))
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_NOBUTTONS));
	
		$content['header'] = MsgPicker::msg()->getMessage($head);
		$content['body'] = MsgPicker::msg()->getMessage($question);
		$content['footer'] = $this->createQuestionFooter($_POST['buttons']);
	
		echo json_encode($content);
	}
	
	private function createQuestionFooter($buttons)
	{
		$html = '';
	
		while ( ($buttonaction = current($buttons)) !== FALSE ) {
			$html .= BsHtml::button(MsgPicker::msg()->getMessage(key($buttons)), array(
					'onclick' => $buttonaction,
			));
			next($buttons);
		}
	
		return $html;
	}
}