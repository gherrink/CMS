<?php

/**
 * 
 * @author Maurice Busch
 * 
 * Managen der Benutzerrechte.
 * 
 */
class RightController extends Controller
{
	
	public function actionAssign($role, $user)
	{
		Yii::app()->authManager->assign($role, $user);
	}
	
	public function actionCreate()
	{
		$auth = new DbAuthManager();
		$auth = Yii::app()->authManager;
		
		$this->createOperationContact($auth);
		$this->createOperationLogin($auth);
		$this->createOperationSite($auth);
		$this->createOperationContent($auth);
		
		//Visitor
		$role=$auth->createRole(MSG::VISITOR);
// 		$role = $auth->getAuthItem(MSG::VISITOR);
		$this->addVisitorRights($role);
		
		//User
		$role=$auth->createRole(MSG::USER);
// 		$role=$auth->getAuthItem(MSG::USER);
		$this->addUserRights($role);
		
		//Member
		$role=$auth->createRole(MSG::MEMBER);
// 		$role=$auth->getAuthItem(MSG::MEMBER);
		$this->addMemberRights($role);
		
		//Moderator Site
		$role=$auth->createRole(MSG::MSITE);
// 		$role=$auth->getAuthItem(MSG::MSITE);
		$this->addMsiteRights($role);
	}
	
	private function createOperationContact($auth)
	{
		$auth->createOperation('contact');
	}
	
	private function createOperationLogin($auth)
	{
		$auth->createOperation('login');
		$auth->createOperation('logout');
		$auth->createOperation('register');
		$auth->createOperation('changeMail');
		$auth->createOperation('resendMail');
	}
	
	private function createOperationSite($auth)
	{
		$auth->createOperation('createSite');
		$auth->createOperation('updateSite');
		$auth->createOperation('deleteSite');
	}
	
	private function createOperationContent($auth)
	{
		$auth->createOperation('createContent');
		$auth->createOperation('updateContent');
		$auth->createOperation('deleteContent');
	}
	
	private function addVisitorRights($role)
	{
		$role->addChild('contact');
		$role->addChild('login');
		$role->addChild('register');
		$role->addChild('changeMail');
		$role->addChild('resendMail');
	}
	
	private function addUserRights($role)
	{
		$role->addChild('logout');
		$role->addChild('contact');
	}
	
	private function addMemberRights($role)
	{
		
	}
	
	private function addMsiteRights($role)
	{
		$role->addChild('createSite');
		$role->addChild('updateSite');
		$role->addChild('deleteSite');
		$role->addChild('createContent');
		$role->addChild('updateContent');
		$role->addChild('deleteContent');
	}
	
}