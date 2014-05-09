<?php
/**
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 */
class ContentController extends CRUDController
{
	public function findModel($name, $editLng)
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
	
	/**
	 * 
	 * @param string $name
	 */
	public function actionSaveText($name)
	{
		$this->checkAccess('updateContentText');
		
		if(! isset($_POST['content']))
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOCONTENT));
		
		$content = Content::model()->findByPk($name);
		if($content === null)
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND));
		
		$content->text = $_POST['content'];
		if(! $content->update())
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_TEXTNOTUPDATE));
	}
	
	/**
	 * Adds a $content to a $site
	 * @param string $content
	 * @param string $site
	 * @param int $col
	 * @throws CHttpException
	 */
	public function actionAddContent2Site($content, $site, $col = 1)
	{
		$this->checkAccess('addSiteContent');
		
		if($content === 'undefined' || $site === 'undefined')
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_NOTHINGSELECTED));
		
		$mSite = Site::model()->findByAttributes(array('label'=>$site));
		if($mSite === null)
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOTFOUND));
		
		$mContent = Content::model()->findByAttributes(array('label'=>$content));
		if($mContent === null)
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND). $content);
		
		$conditions = "siteid = '{$mSite->siteid}' AND contentid = '{$mContent->contentid}'";
		if(SiteContent::model()->exists($conditions))
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITECONTENT_EXISTS));
		
		$siteContent = new SiteContent();
		$siteContent->siteid = $mSite->siteid;
		$siteContent->contentid = $mContent->contentid;
		$siteContent->position = SiteContent::getLastPosition($site) + 1;
		$siteContent->col = $col;
		
		if(! $siteContent->insert())
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTADD2SITE));
		
		echo json_encode(array('success'=>Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$site))));
	}
}