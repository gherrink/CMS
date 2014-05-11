<?php
/**
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @version 0.1
 * @copyright 2014
 */

/*
 * @var MenuController $this
 * @var Menu $menupoint
 * @var boolean $edit
 */

$toggle = ($menupoint->url_intern && $menupoint->url === null && $menupoint->site === null);

$urlEdit = Yii::app()->createAbsoluteUrl('menu/update', array('name'=>'update', 'editLng'=>$menupoint->languageid, 'name'=>$menupoint->menuid));
$urlDelete = Yii::app()->createAbsoluteUrl('menu/delete', array('name'=>'delete', 'editLng'=>$menupoint->languageid, 'name'=>$menupoint->menuid));
$urlQuestionDelete = Yii::app()->createAbsoluteUrl('site/question', array(
		'head'=>MSG::HEAD_QUESTION_REALYDELETE,
		'question'=>MSG::QUESTION_DELETE_MENU,
));
$jsonDelete = json_encode(array('buttons'=>array(
		MSG::BTN_YES => "cmsAjax('$urlDelete'); $('#modalmsg').modal('hide');",
		MSG::BTN_NO => "$('#modalmsg').modal('hide');",
)));

?>

<div class="list-group-item" id="<?php echo $menupoint->menuid; ?>">
	<?php 
		$htmlOptions = array();
		
		if($toggle)
			$htmlOptions = array('onclick'=>"$('#{$menupoint->menuid}.submenu').toggle();", 'class'=>'right-caret');
			
		$htmlOptions['icon'] = $menupoint->icon;
		
		echo BsHtml::button($menupoint->label, $htmlOptions);
	?>
	<span class="pull-right">
		<span style="margin-right: 7px;">
			<?php if(! $toggle):?>
				<span style="margin-right: 15px;"><?php echo $menupoint->site.substr($menupoint->url, 0, 20)?></span>
			<?php endif;?>
			<span><?php echo MsgPicker::msg()->getMessage($menupoint->roleaccess);?></span>
		</span>
		<span class="btn-group">
			<?php 
				echo BsHtml::button('', array(
					'icon' => BsHtml::GLYPHICON_EDIT,
					'onclick' => "cmsShowModalAjax('modal', '$urlEdit');",
				));
				echo BsHtml::button('', array(
					'icon' => BsHtml::GLYPHICON_ARROW_DOWN,
				));
				echo BsHtml::button('', array(
					'icon' => BsHtml::GLYPHICON_ARROW_UP,
				));
				echo BsHtml::button('', array(
					'icon' => BsHtml::GLYPHICON_TRASH,
					'onclick'=>"cmsShowModalAjax('modalmsg', '$urlQuestionDelete', $jsonDelete);",
				));
			?>
		</span>
	</span>
	<?php 
		if($toggle)
		{
			$menupoints = Menu::model()->findAllByAttributes(array('parent_menuid'=>$menupoint->menuid, 'parent_languageid'=>$menupoint->languageid));
			$this->renderPartial('_menu', array('menupoints'=>$menupoints, 'id'=>$menupoint->menuid, 'edit'=>$edit));
		}
	?>
</div>