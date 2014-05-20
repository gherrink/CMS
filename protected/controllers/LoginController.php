<?php
/**
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class LoginController extends Controller
{
	
	public $defaultAction = 'login';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new User('login');
		$modelCheck = new ModelCheck($model, 'User', 'login');
		
		if($this->checkModel($modelCheck))
		{
			if($this->loginUser($model))
				$this->redirect(Yii::app()->user->returnUrl);
			else 
				$this->addErrorMessage(new Message(MSG::ERROR_LOGIN_PWWRONG));
		}
		
		$this->render('login',array('model'=>$model));
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * Displays the register page and registers an user.
	 */
	public function actionRegister()
	{
		$model = new User('register');
		$modelCheck = new ModelCheck($model, 'User', 'register', 'register-form');
		
		if($this->checkModel($modelCheck))
		{
			if($this->registerUser($model))
			{
				Yii::app()->authManager->assign(MSG::USER, $model->userid);
				$this->addSuccessMessage(new Message(MSG::SUCCESS_LOGIN_REGISTER));
				$this->render('login', array('model'=>new User('login')));
				Yii::app()->end();
			}
			else 
				$this->addErrorMessage(new Message(MSG::ERROR_LOGIN_NOTREGISTERED));
		}
		
		$this->render('register',array('model'=>$model));
	}
	
	public function actionUserValidate($user, $key)
	{
		$valid = UserValidate::model()->findByAttributes(array('userid'=>$user, 'validateid'=>$key));
		$error = true;
		if($valid !== null)
		{
			$user = $valid->user;
			$user->mail_valid = true;
			if($user->update())
				$error = false;
		}
		
		if($error)
			$this->addErrorMessage(new Message(
					MSG::ERROR_LOGIN_USERVALIDATE,
					array('mailchange' => Yii::app()->createUrl('login/changeMail'))
			));
		else
			$this->addSuccessMessage(new Message(MSG::SUCCESS_LOGIN_USERVALIDATE));
		
		$this->render('login', array('model'=>new User('login')));
	}
	
	/**
	 * Resends the registermail to an user.
	 * @param string $key
	 */
	public function actionSendRegisterMail($user, $key)
	{
		$valid = UserValidate::model()->findByAttributes(array(
			'userid'=>$user,
			'validateid'=>$key
		));
		
		if($valid !== null)
		{
			$user = $valid->user;
			$valid->validateid = Yii::app()->key->getUniquKey();
			
			$error = true;
			
			if($valid->update(array('validateid')))
				if(Yii::app()->mail->sendRegisterMail($user, $valid))
					$error = false;
			
			if(! $error)
				$this->addSuccessMessage(new Message(MSG::SUCCESS_LOGIN_RESENDMAIL));
			else
				$this->addErrorMessage(new Message(MSG::ERROR_LOGIN_RESENDMAIL));
		}
		
		$this->render('login', array('model'=>new User('login')));
	}
	
	/**
	 * Changes the mail of an user.
	 */
	public function actionChangeMail()
	{
		$model = new User('mail');
		$modelCheck = new ModelCheck($model, 'User', 'changeMail', 'changeMail-form');
		
		if($this->checkModel($modelCheck))
		{
			$identity = new UserIdentity($model);
			$user = $identity->authenticate();
			
			if($user)
			{
				$error = true;
				$user->mail = $model->mail;
				if($user->update(array('mail')))
				{
					$valid = $user->validate;
					$valid->validateid = Yii::app()->key->getUniquKey();
						
					if($valid->update(array('validateid')))
						if(Yii::app()->mail->sendRegisterMail($user, $valid))
							$error = false;
				}
				if($error)
					$this->addErrorMessage(new Message(MSG::ERROR_LOGIN_MAILCHANGE));
				else 
					$this->addSuccessMessage(new Message(MSG::SUCCESS_LOGIN_MAILCHANGE));
			}
			else 
				$this->addErrorMessage(new Message(MSG::ERROR_LOGIN_PWWRONG));
		}
		
		$this->render('changeMail', array('model'=>$model));
	}
	
	/**
	 * Logs in the user.
	 * @param User $user
	 * @return boolean
	 */
	private function loginUser(User $user)
	{
		$identity = new UserIdentity($user);
		$user = $identity->authenticate();
		
		if($user)
		{
			if($user->mail_valid)
			{
				Yii::app()->user->login($identity);
				
				//@TODO Login des Benutzers speichern
				
				return true;
			}
			else
			{
				$valide = $user->userValidate;
				$this->addWarningMessage(new Message(
					MSG::WARNING_LOGIN_MAILNOTVALID,
					array(
						'mailresend' => Yii::app()->createUrl("login/sendRegisterMail", array('key'=>$valide->validateid)),
						'mailchange' => Yii::app()->createUrl('login/changeMail'),
					)
				));
			}
		}
		return false;
	}
	
	private function registerUser(User $user)
	{
		$user->mail_valid = ! Yii::app()->mail->sendMail;
		$user->password = Yii::app()->keygen->getPasswordKey($user);
		if(! $user->insert())
			return false;
		
		if(! $user->mail_valid)
		{
			$valid = new UserValidate();
			$valid->userid = $user->userid;
			$valid->validateid = Yii::app()->keygen->getMailKey($user->mail);
			
			if(! $valid->insert())
			{
				$user->delete();
				return false;
			}
			
			if(! Yii::app()->mail->sendRegisterMail($user, $valid))
				$this->addErrorMessage(new Message(MSG::WARNING_LOGIN_SENDREGISTERMAIL));
		}
		
		return true;
	}
	
}