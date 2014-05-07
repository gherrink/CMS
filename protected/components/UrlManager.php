<?php // components/MyCUrlManager.php

class UrlManager extends CUrlManager
{
    
	public function createUrl($route, $params=array(), $ampersand='&')
	{		
		return parent::createUrl(Yii::app()->language.'/'.$route, $params, $ampersand);
	}
    
}