<?php
class ContactController extends Controller
{
	public $defaultAction = 'contact';
	
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	
	public function actionContact()
	{
		$model = new ContactForm;
		$modelCheck = new ModelCheck($model, 'ContactForm', 'contact');
		if($this->checkModel($modelCheck))
		{
			if(Yii::app()->mail->sendContactMail($model))
			{
				$this->addSuccessMessage(new Message(MSG::SUCCESS_CONTACT_SENDMAIL));
				$model = new ContactForm();
			}
			else 
				$this->addErrorMessage(new Message(MSG::ERROR_CONTACT_SENDMAIL));
		}
		
		$this->render('contact',array('model'=>$model));
	}
}