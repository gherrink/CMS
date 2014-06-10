<?php
/**
 * Grundimplementierung für alle Controller
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	private $messages = array();
	private $hasMessages = false;
	private $roleaccessSql = null;
	
	/**
	 * Fuegt eine Benutzer-Messege hinzu
	 * @param Message $message
	 */
	private function addMessage(Message $message)
	{
		$this->messages[] = $message;
		$this->hasMessages = true;
	}
	
	/**
	 * Fuegt eine Erfolgsmeldung hinzu
	 * @param Message $message
	 */
	public function addSuccessMessage(Message $message)
	{
		$message->setStatus(BsHtml::ALERT_COLOR_SUCCESS);
		$this->addMessage($message);
	}
	
	/**
	 * Fuegt eine Errormeldung hinzu
	 * @param Message $message
	 */
	public function addErrorMessage(Message $message)
	{
		$message->setStatus(BsHtml::ALERT_COLOR_ERROR);
		$this->addMessage($message);
	}
	
	/**
	 * Fuegt eine Infomeldung hinzu
	 * @param Message $message
	 */
	public function addInfoMessage(Message $message)
	{
		$message->setStatus(BsHtml::ALERT_COLOR_INFO);
		$this->addMessage($message);
	}
	
	/**
	 * Fuegt eine Warnmeldung hinzu
	 * @param Message $message
	 */
	public function addWarningMessage(Message $message)
	{
		$message->setStatus(BsHtml::ALERT_COLOR_WARNING);
		$this->addMessage($message);
	}
	
	/**
	 * Liefert alle Meldungen für den Benutzer
	 * @return multitype:
	 */
	public function getMessages()
	{
		return $this->messages;
	}
	
	/**
	 * Prüft ob Messages vorhanden sind.
	 * @return boolean
	 */
	public function hasMessages()
	{
		return $this->hasMessages;
	}
	
	/**
	 * Prüft das Model ob es korrekt ist.
	 * @param ModelCheck $model
	 * @return boolean
	 */
	public function checkModel(ModelCheck $model)
	{
		//ajax validation
		if(isset($_POST['ajax']) && $_POST['ajax']===$model->getAjax())
		{
			echo CActiveForm::validate($model->getModel());
			Yii::app()->end();
		}
		
		$this->checkAccess($model->getRole());
		
		if(isset($_POST[$model->getModelName()]))
		{
			$model->getModel()->attributes = $_POST[$model->getModelName()];
            return $model->getModel()->validate();
		}
		
		return false;	
	}
	
	/**
	 * Prueft ob der Benutzer zugriffsrechte hat
	 * @param unknown $role
	 * @throws CHttpException
	 * @return boolean
	 */
	public function checkAccess($role)
	{
		if(Yii::app()->user->checkAccess($role))
			return true;
		else 
			/**
			 * @TODO Exception wenn Bentuzer keine Rechte Text hinzufügen.
			 */
			throw new CHttpException(400, "Error");
	}
	
	/**
	 * Erstellen eines SQL WHERE Strings anhand der Benutzerrechte
	 * @param string $colName
	 * @return string
	 */
	public function getRoleaccessSQLWhere($colName = 'roleaccess')
	{
		if($this->roleaccessSql !== null)
			return $this->roleaccessSql;
		
		$sql = "(". $colName ." = '". MSG::VISITOR."'";
		
		if(Yii::app()->user->checkAccess(MSG::USER))
			$sql .= " OR $colName = '" .MSG::USER. "'";
		
		if(Yii::app()->user->checkAccess(MSG::MEMBER))
			$sql .= " OR $colName = '" .MSG::MEMBER. "'";
		
		if(Yii::app()->user->checkAccess(MSG::MSITE))
			$sql .= " OR $colName = '" .MSG::MSITE. "'";
		
		if(Yii::app()->user->checkAccess(MSG::MMENU))
			$sql .= " OR $colName = '" .MSG::MMENU. "'";
		
		if(Yii::app()->user->checkAccess(MSG::MGALLERY))
			$sql .= " OR $colName = '" .MSG::MGALLERY. "'";
		
		if(Yii::app()->user->checkAccess(MSG::MNEWS))
			$sql .= " OR $colName = '" .MSG::MNEWS. "'";
		
		if(Yii::app()->user->checkAccess(MSG::ADMIN))
			$sql .= " OR $colName = '" .MSG::ADMIN. "'";
		
		$sql .= ")";
		
		$this->roleaccessSql = $sql;
		return $sql;
	}
}