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
	
	public function actionAdd2Site()
	{	
		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
		
		$content['header'] = MsgPicker::msg()->getMessage(MSG::HEAD_CONTENT_ADD2SITE);
		$content['body'] = $this->renderPartial('_add2site', array(), true, true);
		$content['footer'] = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_OK), array('onclick'=>"addContent2Site();")).
		BSHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick'=>"$('#modal').modal('hide');"));		
		echo json_encode($content);
	}
		
	public function actionUpdateAdd2Site()
	{
		$model = new Site('search');
		if(isset($_GET['Site']))
			$model->attributes = $_GET['Site'];
		
		$this->renderPartial('_add2site', array(
			'model' => $model,
		));
	}
	
	public function actionAddContent2Site($content, $site, $col = 1)
	{
		$this->checkAccess('addSiteContent');
		
		$mSite = Site::model()->findByAttributes(array('label'=>$site));
		if($mSite === null)
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOTFOUND));
		
		$mContent = Content::model()->findByAttributes(array('label'=>$content));
		if($mContent === null)
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND));
		
		$siteContent = new SiteContent();
		$siteContent->siteid = $mSite->siteid;
		$siteContent->contentid = $mContent->contentid;
		$siteContent->languageid = $mContent->languageid;
		$siteContent->position = SiteContent::getLastPosition($site) + 1;
		$siteContent->col = $col;
		
		/*
		 * @todo Content einer gewissen spalte hinzufügen
		 */
		
		if(! $siteContent->insert())
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTADD2SITE));
		
		echo json_encode(array('success'=>Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$site))));
	}
}