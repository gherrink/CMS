<?php
/**
 * Creats a View with one Column
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */
/* 
 * @var Site $site
 * @var boolean $edit
 * @var string $editLng
 */

if($edit === null || ! Yii::app()->user->checkAccess('editContent'))
	$edit = false;
?>

<div class="row">
	<div class="col-sm-12">
		<?php $this->renderPartial('_contents', array('site'=>$site, 'edit'=>$edit, 'col'=>1, 'editLng'=>$editLng));?>
	</div>
</div>