<?php
/**
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 * 
 * @var SiteController $this 
 * @var Site $model
 * @var BsActiveForm $form
 * @var String $url
 */

$roles = SelectHelper::getSiteRoles();
$layouts = SelectHelper::getLayouts();

$selectedRole = MSG::MSITE;
if($model->roleaccess !== null)
	$selectedRole = $model->roleaccess;

$selectedLayout = MSG::COL01;
if($model->layout !== null)
	$selectedRole = $model->layout;


$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
   	'enableAjaxValidation' => true,
	'id' => 'site-form',
	'htmlOptions'=>array(
		'onsubmit'=>"return false;",
		'onkeypress'=>" if(event.keyCode == 13){ submitForm('modal', 'site-form', '". $url ."'); } ",
	),
	'action' => $url,
));
?>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'label', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<?php
				echo $form->dropDownListControlGroup($model, 'roleaccess', $roles, array(
    				'options' => array($selectedRole=>array('selected'=>true)),
					'labelOptions'=>array('class'=>'control-label required'),
					'controlOptions'=>array('class'=>''),
				));
			?>
		</div>
		<div class="col-sm-6">
			<?php
				echo $form->dropDownListControlGroup($model, 'layout', $layouts, array(
    				'options' => array($selectedLayout=>array('selected'=>true)),
					'labelOptions'=>array('class'=>'control-label required'),
					'controlOptions'=>array('class'=>''),
				));
			?>
		</div>
	</div>
	
	<h4><?php echo MsgPicker::msg()->getMessage(MSG::HEAD_SITE_CREATELANGUAGE)?></h4>
	
	<?php
		if($model->siteid !== null && $model->siteid !== "")
		{
			$languages = SiteLanguage::model()->findAllByAttributes(array('siteid'=>$model->siteid));
			$this->renderPartial('_languages', array('languages'=>$languages, 'form'=>$form));
		}
		else
			$this->renderPartial('_language', array('model'=>new SiteLanguage(), 'form'=>$form));
	?>
	
	<div class="row">
		<div class="col-sm-12">
			<?php echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_SITE_ADDLANGUAGE))?>
		</div>
	</div>
<?php $this->endWidget(); ?>