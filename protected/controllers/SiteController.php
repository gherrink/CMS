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
	
	/**
	 * Seiteninhalt bearbeiten
	 * @param string $name
	 */
	public function actionEdit($name)
	{
		$this->actionSite($name, true);
	}
	
	/**
	 * Create a new Site
	 */
	public function actionCreate($language = null)
	{
		$transaktion = Yii::app()->db->beginTransaction();
		$model = new Site('create');
		$modelCheck = new ModelCheck($model, 'Site', 'createSite', 'site-form');
		$error = '';
		
		if($this->checkModel($modelCheck))
		{
			$model->siteid = Yii::app()->keygen->getUniquKey();
			$model->update_userid = Yii::app()->user->getID();
			$model->update_time = date('Y-m-d H:i:s', time());
			$model->create_userid = Yii::app()->user->getID();
			$model->create_time = date('Y-m-d H:i:s', time());
			$model->layout = strtolower($model->layout);
			
			if($model->insert())
				if($this->createSiteHeader($model))
					try
					{
						$transaktion->commit();
						$this->addSuccessMessage(new Message(MSG::SUCCESS_SITE_CREATE));
						$content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$model->siteid));
						echo json_encode($content);
						Yii::app()->end();
					}
					catch (Exception $e)
					{}
			
			$transaktion->rollBack();
			$error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage(MSG::ERROR_SITE_NOTCREATE));
		}
		
		$urlCreate = Yii::app()->createAbsoluteUrl('site/create');
		$urlExit = Yii::app()->createAbsoluteUrl('site/question', array(
			'head'=>MSG::HEAD_QUESTION_REALYCLOSE,
			'question'=>MSG::QUESTION_EXIT_SITECREATE,
			'button'=>MSG::QUESTION_BTN_REALYCLOSE,
		));
		
		$content['header'] = MsgPicker::msg()->getMessage(MSG::HEAD_SITE_CREATE);
		$content['body'] = $error . $this->renderPartial('_edit', array('model'=>$model, 'url'=>$urlCreate), true);
		$content['footer'] = 
			BSHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick'=>"showModalAjax('modalmsg', '".$urlExit."');")).
			BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CREATE), array('onclick'=>"submitForm('modal', 'site-form', '$urlCreate')"));
		
		echo json_encode($content);
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
	 * Update of the site settings
	 * @param string $name
	 */
	public function actionUpdate($name)
	{
		$transaktion = Yii::app()->db->beginTransaction();
		$model = Site::model()->findByAttributes(array('siteid' => $name));
		$error = '';
		
		if($model === null)
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXEPTION_SITE_NOTFOUND));
		
		$site = new Site('update');
		$modelCheck = new ModelCheck($site, 'Site', 'updateSite', 'site-form');
		if($this->checkModel($modelCheck))
		{
			$model->update_userid = Yii::app()->user->getID();
			$model->update_time = date('Y-m-d H:i:s', time());
			$model->layout = strtolower($site->layout);
			$model->roleaccess = $site->roleaccess;
			$model->label = $site->label;
			
			if($model->update())
				if($this->updateSiteHeader($model))
					try
					{
						$transaktion->commit();
						$this->addSuccessMessage(new Message(MSG::SUCCESS_SITE_UPDATE));
						$content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$model->siteid));
						echo json_encode($content);
						Yii::app()->end();
					}
					catch (Exception $e)
					{}
			
			$transaktion->rollBack();
			$error = BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage(MSG::ERROR_SITE_NOTUPDATE));
		}
		
		$urlUpdate = Yii::app()->createAbsoluteUrl('site/update', array('name'=>$name));
		$urlExit = Yii::app()->createAbsoluteUrl('site/question', array(
			'head'=>MSG::HEAD_QUESTION_REALYCLOSE,
			'question'=>MSG::QUESTION_EXIT_SITECREATE,
			'button'=>MSG::QUESTION_BTN_REALYCLOSE,
		));
		
		$content['header'] = MsgPicker::msg()->getMessage(MSG::HEAD_SITE_UPDATE);
		$content['body'] = $error . $this->renderPartial('_edit', array('model'=>$model, 'url'=>$urlUpdate), true);
		$content['footer'] = 
			BSHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick'=>"showModalAjax('modalmsg', '".$urlExit."');")).
			BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array('onclick'=>"submitForm('modal', 'site-form', '$urlUpdate')"));
		
		echo json_encode($content);
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
	
	/**
	 * Gives a JSON array for a Question
	 * @param String $question
	 */
	public function actionQuestion($head, $question, $button)
	{
		if(! defined('MSG::'.$head))
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXEPTION_CONST_NOTDEFINED, array('const'=>$head)));
		
		if(! defined('MSG::'.$question))
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXEPTION_CONST_NOTDEFINED, array('const'=>$question)));
		
		if(! defined('MSG::'.$button))
			throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXEPTION_CONST_NOTDEFINED, array('const'=>$button)));
		
		$content['header'] = MsgPicker::msg()->getMessage($head);
		$content['body'] = MsgPicker::msg()->getMessage($question);
		$content['footer'] = $this->createQuestionFooter($button);
		
		echo json_encode($content);
	}
	
	private function createQuestionFooter($button)
	{
		$buttons = '';
		switch ($button) {
			case MSG::QUESTION_BTN_REALYCLOSE:
				$buttons = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_YES), array(
					'onclick' => "$('#modal').modal('hide'); $('#modalmsg').modal('hide');",
				));
				$buttons .= BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_NO), array(
					'onclick' => "$('#modalmsg').modal('hide');",
				));
			break;
			
			default:
				;
			break;
		}
		
		return $buttons;
	}
}