<?php

/**
 * 
 * Die Klasse MsgPicker liefert Methoden zur selektierung von Sprachen
 * und die dazupassenden Sprachdateien
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */

class MsgPicker {
	
	const ERROR_NO_LANGUAGE_FOUND	= 'The language array was not found';
	
	private static $defaultLanguage = 'de';
	private static $availableLanguages = array('de'=>'de', 'en'=>'en');
	private static $msgPath = 'messages/msg';
	private $messages = array();
	
	private static $instance;
	
	/**
	 * 
	 */
	private function __construct($language = '')
	{
		$this->pickLanguage($language);
	}
	
	/**
	 * Verwalten der Instance
	 * @return MsgPicker
	 */
	public static function msg($language = '')
	{
		if (! isset(self::$instance))
			self::$instance = new MsgPicker($language);
		else 
			if($language !== '' && Yii::app()->language !== $language)
				$this->pickLanguage($language);
			
		return self::$instance;
	}
	
	/**
	 * Waehlt die aktuelle Sprache die vom Browser uebermittelt wurde
	 */
	private function pickLanguage($language = '')
	{
		$app = Yii::app();
		if($language !== '')
		{
			$app->setLanguage($language);
		}
		else if (isset($_GET['language']))
		{
			$app->setLanguage($_GET['language']);
		}
		else if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER))
		{
			$app->setLanguage(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0,2));
		}
		
		if($app->language === null || $app->language === ""
				|| ! array_key_exists($app->language, self::$availableLanguages)
				|| ! Language::isLanguageActive($app->language))
		{
			$app->setLanguage(self::$defaultLanguage);
		}
		
		$this->setMessages();
	}
	
	/**
	 * Setzt das Message Array
	 */
	private function setMessages()
	{
		$file = dirname(__FILE__) .'/../../'. self::$msgPath .'/'. Yii::app()->language .'.php';
		if(file_exists($file))
		{
			$this->messages = include $file;
		}
		else 
			throw new CHttpException(500, MsgPicker::ERROR_NO_LANGUAGE_FOUND);
	}
	
	/**
	 * @todo exception if $param key not exists and if in $param not enath keys
	 * @param unknown $code
	 * @param unknown $params
	 * @throws CHttpException
	 * @return Ambigous <mixed, multitype:>
	 */
	public function getMessage($code, $params = array())
	{
		if(! array_key_exists($code, $this->messages))
			throw new CHttpException(400, $this->getMessage(MSG::EXCEPTION_MSG_NOTFOUND, array('msg'=>$code)));
		
		$msg = $this->messages[$code];
		while ( ($str = current($params)) !== FALSE ) {
			$msg = str_replace('###'.key($params).'###', $str, $msg);
			next($params);
		}
		return $msg;
	}
	
	public static function getAvailableLanguages()
	{
		return self::$availableLanguages;
	}
	
	public static function getMsgPath()
	{
		return self::$msgPath;
	}
	
}