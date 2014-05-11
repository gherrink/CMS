<?php
/**
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @version 0.1
 * @copyright 2014
 */

/* 
 * @var MenuController $this 
 * @var Menu $model
 * @var BsActiveForm $form
 */

if($model->languageid === null || $model->languageid === '')
	if(array_key_exists('editLng', $_GET))
	{
		$model->languageid = $_GET['editLng'];
		$model->parent_languageid = $_GET['editLng'];
	}
	
if($model->scenario === 'update')
	if($model->url == null && $model->site == null)
		$model->haschilds = true;
	
if(array_key_exists('parent', $_GET))
{
	$model->parent_menuid = $_GET['parent'];
	$menu = Menu::model()->findByAttributes(array('menuid'=>$model->parent_menuid, 'languageid'=>$model->languageid));
	$model->parent_menu = $menu->label;
}
elseif ($model->parent_menuid !== null)
{
	$menu = Menu::model()->findByAttributes(array('menuid'=>$model->parent_menuid, 'languageid'=>$model->languageid));
	$model->parent_menu = $menu->label;
}

$model->oldparent_menuid = $model->parent_menuid;

$roles = SelectHelper::getMenuRoles();

$selectedRole = MSG::MMENU;
if($model->roleaccess !== null)
	$selectedRole = $model->roleaccess;

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
	'enableAjaxValidation' => false,
	'id' => 'menu-form',
	'action' => array('menu/edit'),
));	
?>

<div class="row">
	<div class="col-sm-9">
		<?php echo $form->textFieldControlGroup($model, 'label', array(
				'labelOptions'=>array('class'=>'col-lg-4'),
				'controlOptions'=>array('class'=>'col-lg-8'),
			));
			echo $form->hiddenField($model, 'languageid');
		?>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<?php 
			echo $form->textFieldControlGroup($model, 'parent_menu', array(
				'labelOptions'=>array('class'=>'col-lg-4'),
				'controlOptions'=>array('class'=>'col-lg-8'),
				'disabled' => true,
			));
			echo $form->hiddenField($model, 'oldparent_menuid');
			echo $form->hiddenField($model, 'parent_menuid');
			echo $form->hiddenField($model, 'parent_languageid');
		?>
	</div>
	<div class="col-sm-3 btn-group">
		<?php 
			$url = Yii::app()->createAbsoluteUrl('menu/view', array('head'=>MSG::HEAD_MENU_PARENTMENU));
			$json = json_encode(array('buttons'=>array(
				MSG::BTN_EXIT => "$('#modalmenu').modal('hide');",
				MSG::BTN_OK => "cmsMenuInsertParent();",
			)));
		
			echo BsHtml::button('', array(
				'icon' => BsHtml::GLYPHICON_SEARCH,
				'onclick' => "cmsShowModalAjax('modalmenu', '$url', $json);",
			));
			echo BsHtml::button('', array(
				'icon' => BsHtml::GLYPHICON_REMOVE,
				'onclick' => 'cmsMenuRemoveParent();',
			));
		?>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<div class="form-group">
			<?php echo $form->label($model, 'haschilds', array('class'=>'control-label col-lg-4'));?>
			<div class="col-lg-8" style="padding-top: 12px">
				<?php echo $form->checkBox($model, 'haschilds', array(
						'class'=>'control-label',
						'onchange'=>'cmsMenuChangeUrl()',
					)); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<div class="form-group">
			<?php echo $form->label($model, 'url_intern', array('class'=>'control-label col-lg-4'));?>
			<div class="col-lg-8" style="padding-top: 12px">
				<?php echo $form->checkBox($model, 'url_intern', array(
						'class'=>'control-label',
						'onchange'=>'cmsMenuChangeUrl()',
						'disabled' => $model->haschilds,
					)); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<?php echo $form->textFieldControlGroup($model, 'url', array(
				'labelOptions'=>array('class'=>'col-lg-4'),
				'controlOptions'=>array('class'=>'col-lg-8'),
				'disabled' => ($model->url_intern || $model->haschilds),
			));
		?>
	</div>
	<div class="col-sm-3">
		<?php 
			$url = Yii::app()->createAbsoluteUrl('site/view', array('head'=>MSG::HEAD_MENU_LINK2SITE));
			$json = json_encode(array('buttons'=>array(
				MSG::BTN_EXIT => "$('#modalmenu').modal('hide');",
				MSG::BTN_OK => "cmsMenuInsertLink();",
			)));
			

			echo BsHtml::button('', array(
				'icon' => BsHtml::GLYPHICON_SEARCH,
				'onclick' => "cmsShowModalAjax('modalmenu', '$url', $json);",
				'disabled' => ! $model->url_intern,
				'id' => 'link-select',
			));
		?>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<?php 
			echo $form->dropDownListControlGroup($model, 'roleaccess', $roles, array(
				'options' => array($selectedRole=>array('selected'=>true)),
				'labelOptions'=>array('class'=>'col-lg-4'),
				'controlOptions'=>array('class'=>'col-lg-8')
			));
		?>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<?php echo $form->hiddenField($model, 'icon')?>
		<?php echo $form->label($model, 'icon', array('class'=>'control-label col-lg-4'));?>
		<div class="col-lg-8">
			<?php
				if($model->icon !== null && $model->icon !== '')
					echo BSHtml::icon($model->icon, array('class'=>'control-label', 'id'=>'menuicon'));
				else 
					echo BSHtml::icon('', array('class'=>'control-label', 'id'=>'menuicon'));
			?>
		</div>
	</div>
	<div class="col-sm-3 btn-group">
		<?php 
			$url = Yii::app()->createAbsoluteUrl('menu/iconView');
			
			echo BsHtml::button('', array(
				'icon' => BsHtml::GLYPHICON_SEARCH,
				'onclick' => "cmsShowModalAjax('modalmenu', '$url');",
			));
			echo BsHtml::button('', array(
				'icon' => BsHtml::GLYPHICON_REMOVE,
				'onclick' => 'cmsMenuRemoveIcon()',
			));
		?>
	</div>
</div>

<?php $this->endWidget(); ?>
