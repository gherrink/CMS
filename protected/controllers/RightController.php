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
	
	/**
	 * index.php/right/assign?role=MSITE&user=mrbirne
	 * @param unknown $role
	 * @param unknown $user
	 */
	public function actionAssign($role, $user)
	{
		Yii::app()->authManager->assign($role, $user);
	}
	
	public function actionCreate()
	{
// 		$auth = new DbAuthManager();
		$auth = Yii::app()->authManager;
		
		$this->createOperationContact($auth);
		$this->createOperationLogin($auth);
		$this->createOperationSite($auth);
		$this->createOperationNews($auth);
		$this->createOperationContent($auth);
		$this->createOperationGallery($auth);
		$this->createOperationMenu($auth);
		
		//Visitor
// 		$role=$auth->createRole(MSG::VISITOR);
		$role = $auth->getAuthItem(MSG::VISITOR);
		$this->addVisitorRights($role);
		
		//User
// 		$role=$auth->createRole(MSG::USER);
		$role=$auth->getAuthItem(MSG::USER);
		$this->addUserRights($role);
		
		//Member
// 		$role=$auth->createRole(MSG::MEMBER);
		$role=$auth->getAuthItem(MSG::MEMBER);
		$this->addMemberRights($role);
		
		//Moderator Site
// 		$role=$auth->createRole(MSG::MSITE);
		$role=$auth->getAuthItem(MSG::MSITE);
		$this->addMsiteRights($role);
		
		//Moderator News
// 		$role=$auth->createRole(MSG::MNEWS);
		$role=$auth->getAuthItem(MSG::MNEWS);
		$this->addMnewsRights($role);
		
		//Moderator Gallery
// 		$role=$auth->createRole(MSG::MGALLERY);
		$role=$auth->getAuthItem(MSG::MGALLERY);
		$this->addMnewsRights($role);
		
		//Moderator Gallery
// 		$role=$auth->createRole(MSG::MMENU);
		$role=$auth->getAuthItem(MSG::MMENU);
		$this->addMmenuRights($role);
	}
	
	private function createOperationContact($auth)
	{
// 		$auth->createOperation('contact');
	}
	
	private function createOperationLogin($auth)
	{
// 		$auth->createOperation('login');
// 		$auth->createOperation('logout');
// 		$auth->createOperation('register');
// 		$auth->createOperation('changeMail');
// 		$auth->createOperation('resendMail');
	}
	
	private function createOperationSite($auth)
	{
// 		$auth->createOperation('editSite');
// 		$auth->createOperation('createSite');
// 		$auth->createOperation('updateSite');
// 		$auth->createOperation('deleteSite');
// 		$auth->createOperation('deleteSiteLanguage');
// 		$auth->createOperation('addSiteNewLanguage');
// 		$auth->createOperation('addSiteContent');
// 		$auth->createOperation('deleteSiteContent');
// 		$auth->createOperation('readSite');
	}
	
	private function createOperationContent($auth)
	{
// 		$auth->createOperation('editContent');
// 		$auth->createOperation('createContent');
// 		$auth->createOperation('updateContent');
// 		$auth->createOperation('updateContentText');
// 		$auth->createOperation('deleteContent');
// 		$auth->createOperation('readContent');
	}
	
	private function createOperationNews($auth)
	{
// 		$auth->createOperation('editNews');
// 		$auth->createOperation('createNews');
// 		$auth->createOperation('updateNews');
// 		$auth->createOperation('deleteNews');
// 		$auth->createOperation('readNews');
	}
	
	private function createOperationGallery($auth)
	{
// 		$auth->createOperation('createGallery');
// 		$auth->createOperation('updateGallery');
// 		$auth->createOperation('deleteGallery');
// 		$auth->createOperation('editGallery');
// 		$auth->createOperation('readGallery');
	}
	
	private function createOperationMenu($auth)
	{
// 		$auth->createOperation('createMenu');
// 		$auth->createOperation('updateMenu');
// 		$auth->createOperation('deleteMenu');
// 		$auth->createOperation('editMenu');
// 		$auth->createOperation('readMenu');
	}
	
	private function addVisitorRights($role)
	{
// 		$role->addChild('contact');
// 		$role->addChild('login');
// 		$role->addChild('register');
// 		$role->addChild('changeMail');
// 		$role->addChild('resendMail');
	}
	
	private function addUserRights($role)
	{
// 		$role->addChild('logout');
// 		$role->addChild('contact');
	}
	
	private function addMemberRights($role)
	{
		
	}
	
	private function addMsiteRights($role)
	{
// 		$role->addChild('editSite');
// 		$role->addChild('createSite');
// 		$role->addChild('updateSite');
// 		$role->addChild('deleteSite');
// 		$role->addChild('deleteSiteLanguage');
// 		$role->addChild('addSiteNewLanguage');
// 		$role->addChild('addSiteContent');
// 		$role->addChild('deleteSiteContent');
// 		$role->addChild('editContent');
// 		$role->addChild('createContent');
// 		$role->addChild('updateContent');
// 		$role->addChild('updateContentText');
// 		$role->addChild('deleteContent');
// 		$role->addChild('readContent');
// 		$role->addChild('readSite');
	}
	
	private function addMnewsRights($role)
	{
// 		$role->addChild('editNews');
// 		$role->addChild('createNews');
// 		$role->addChild('updateNews');
// 		$role->addChild('deleteNews');
// 		$role->addChild('readNews');
	}
	
	private function addMgalleryRights($role)
	{
// 		$role->addChild('editGallery');
// 		$role->addChild('createGallery');
// 		$role->addChild('updateGallery');
// 		$role->addChild('deleteGallery');
// 		$role->addChild('readGallery');
	}
	
	private function addMmenuRights($role)
	{
// 		$role->addChild('editMenu');
// 		$role->addChild('createMenu');
// 		$role->addChild('updateMenu');
// 		$role->addChild('deleteMenu');
// 		$role->addChild('readMenu');
	}
}