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
	const ERROR_MSG_NOT_FOUND		= 'ERROR_MSG_NOT_FOUND';
	
	private static $defaultLanguage = 'de';
	private static $availableLanguages = array('de'=>'de');
	private static $msgPath = 'messages/msg';
	private $messages = array();
	
	private static $instance;
	
	/**
	 * 
	 */
	private function __construct()
	{
		$this->pickLanguage();
	}
	
	/**
	 * Verwalten der Instance
	 * @return MsgPicker
	 */
	public static function msg()
	{
		if (! isset(self::$instance))
			self::$instance = new MsgPicker();
		return self::$instance;
	}
	
	/**
	 * Waehlt die aktuelle Sprache die vom Browser uebermittelt wurde
	 */
	private function pickLanguage()
	{
		$app = Yii::app();
		if (isset($_POST['language']))
		{
			$app->language = $_POST['language'];
			$app->session['language'] = $app->language;
		}
		else if (isset($app->session['language']))
		{
			$app->language = $app->session['language'];
		}
		else 
		{
			$app->language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
		}
		
		if($app->language != null || $app->lanauge === ""
				|| ! array_key_exists($app->language, $this->availableLanguages)
				|| ! Language::isLanguageActive($app->language))
		{
			$app->language = $this->defaultLanguage;
		}
		
		$this->setMessages();
	}
	
	/**
	 * Setzt das Message Array
	 */
	private function setMessages()
	{
		$file = Yii::app()->basePath .'/'. $this->msgPath .'/'. Yii::app()->language .'.php';
		if(file_exists($file))
		{
			$this->messages = include_once $file;
		}
		else 
			throw new CHttpException(500, MsgPicker::ERROR_NO_LANGUAGE_FOUND);
	}
	
	public function getMessage($code, $params = array())
	{
		if(! array_key_exists($code, $this->messages))
			throw new CHttpException(400, $this->getMessage(self::ERROR_MSG_NOT_FOUND, array('msg'=>$code)));
		
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