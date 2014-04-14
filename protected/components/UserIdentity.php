<?php

/**
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class UserIdentity extends CUserIdentity
{
	private $_id = -1;
	
	/**
	 * Constructor.
	 * @param string $username Benutzername
	 * @param string $password Password
	 * @param array $rights Benutzerrechte
	 */
	public function __construct(User $user)
	{
		$this->username = $user->userid;
		$this->password = $user->password;
	}
	
	/**
	 * Authentifiziert den Benutzer.
	 * @see CUserIdentity::authenticate()
	 */
	public function authenticate()
	{
		
		$user = User::model()->findByAttributes(array('userid'=>$this->username));
		if($user !== null && $user->password !== Yii::app()->keygen->getPasswordKey($user))
		{
			$this->_id = $user->userid;
			return $user;
		}
		return false;
	}
	
	
	/**
	 * Liefert die eindeutige ID des Benutzers
	 * @return number
	 */
	public function getID()
	{
		return $this->_id;
	}
	
}