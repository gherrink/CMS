<?php

/*
 * Copyright (C) 2014 Maurice Busch <busch.maurice@gmx.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The LayoutManager manages the available Layouts
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */

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
	private static $availableLanguages = array('de'=>'de');
	private static $msgPath = 'messages/msg';
	private $messages = array();
	
	private static $instance;
	
	/**
	 * Constructor sets the message-array with the given $language
	 */
	private function __construct($language = '')
	{
		$this->pickLanguage($language);
	}
	
	/**
	 * Creates one instance if one is existing it gives the existing one
     * if you want to change the language you can give the new languageid
     * and the MsgPicker will give you frome now on Messages in the new
     * Language.
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
	 * Picks the actual Language.
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
				|| ! self::isAvailable($app->language)
				|| ! Language::isLanguageActive($app->language))
		{
			$app->setLanguage(self::$defaultLanguage);
		}
		
		$this->setMessages();
	}
	
	/**
	 * Set the Message-array with the picked Language.
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
	
    /**
     * returns an Array with all available Languages
     * @return string[]
     */
	public static function getAvailableLanguages()
	{
		return self::$availableLanguages;
	}
	
    /**
     * Returns the path where the language arrays are placed
     * @return string
     */
	public static function getMsgPath()
	{
		return self::$msgPath;
	}
	
    /**
     * Checks if the language is Available.
     * @param string $language
     * @return boolean
     */
	public static function isAvailable($language)
	{
		return array_key_exists($language, self::$availableLanguages);
	}
	
}