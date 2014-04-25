<?php
/**
 * Creats a View with one Column
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */
/* 
 * @var $site Site
 * @var $edit boolean
 */

if($edit === null || ! Yii::app()->user->checkAccess('contentEdit'))
	$edit = false;
?>

<div class="col-sm-12">
	<?php $this->renderPartial('_contents', array('site'=>$site, 'edit'=>$edit, 'col'=>1));?>
</div>