<?php // components/MyCUrlManager.php

class UrlManager extends CUrlManager
{
    
	public function createUrl($route, $params=array(), $ampersand='&')
	{
		if(! array_key_exists('language', $params))
		{
			$params['language'] = Yii::app()->language;
		}
		
		return parent::createUrl($route, $params, $ampersand);
	}
    
}