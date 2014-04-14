<?php

class SiteController extends Controller
{

	/**
	 * This is the default 'index' action that renders
	 * the Homepage.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/**
	 * This is the site action, it renders a Site with
	 * html content from the database.
	 * @param unknown $name
	 * @throws CHttpException
	 */
	public function actionSite($name, $edit = false)
	{
		$site = Site::model()->findByAttributes(array('siteid'=>$name));
		if($site === null)
			throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXEPTION_SITE_NOTFOUND));
		
		$this->checkAccess($site->roleaccess);
		$editable = Yii::app()->user->checkAccess('updateSite');
		
		if($editable)
			$this->render('site', array('layout'=>$site->layout, 'site'=>$site, 'edit'=>$edit, 'editable'=>$editable));
		else 
		{
			if(SiteContentView::model()->countBySql("SELECT COUNT(*) FROM SiteContentView WHERE siteid = '$name' AND languageid = '".Yii::app()->language."' AND {$this->getRoleaccessSQLWhere()}") > 0)
				$this->render('site', array('layout'=>$site->layout, 'site'=>$site, 'edit'=>$edit, 'editable'=>$editable));
			else 
				throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXEPTION_SITE_NOCONTENT));
		}
	}
	
	public function actionCreate()
	{
		$this->checkAccess('createSite');
		
		$content['header'] = 'hallo';
		$content['body'] = $this->renderPartial('_create', array(), true);
		$content['footer'] = 'foot';
		echo json_encode($content);
	}
	
	public function actionUpdate($name)
	{
		actionSite($name, true);
	}
	
	public function actionDelete($name)
	{
		//@TODO deleteSite
	}
	
	public function actionCreateContent()
	{
		//@TODO createContent
	}
	
	public function actionUpdateContent()
	{
		//@TODO updateContent
	}
	
	public function actionDeleteContent()
	{
		//@TODO deleteContent
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