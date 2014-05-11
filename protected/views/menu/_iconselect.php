<?php
/**
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @version 0.1
 * @copyright 2014
 */

/* 
 * @var MenuController $this 
 */
 
// echo BsHtml::button('', array('icon'=>'glyphicon-inline'));
$class = new ReflectionClass('BsHtml');
$consts = $class->getConstants();

while ( ($icon = current($consts)) !== false ) {
	if(strpos(key($consts), 'GLYPHICON_') !== false)
	{
		echo BsHtml::button('', array(
			'icon'=>$icon,
			'size'=>BsHtml::BUTTON_SIZE_LARGE,
			'style'=>'margin: 4px;',
			'onclick'=>"cmsMenuChangIcon('$icon')"
		));
	}
	next($consts);
}

?>