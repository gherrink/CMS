<?php
class KeyGenerator extends CApplicationComponent
{
	public $userKey = 'rSS8lcO2^/j5|\6%bCw!';
	public $passwordKey = '#hBR Wk5tL%c,HP:X`3U';
	
	public function getPasswordKey(User $user)
	{
		return hash('sha256', $this->passwordKey.hash('sha256', $user->password.$user->userid));
	}
	
	public function getMailKey($mail)
	{
		return hash('sha256', $this->userKey.$mail);
	}
	
	public function getUniquKey()
	{
		return md5(uniqid(rand(), TRUE));
	}
}