<?php // components/MyCUrlManager.php

class UrlManager extends CUrlManager
{
    
	public function createUrl($route, $params=array(), $ampersand='&')
	{
		if(! array_key_exists('language', $params))
		{
			$params['language'] = Yii::app()->language;
		}
		
		if(! array_key_exists('editLng', $params) && array_key_exists('editLng', $_GET))
			$params['editLng'] = $_GET['editLng'];
		
		return parent::createUrl($route, $params, $ampersand);
	}
    
}