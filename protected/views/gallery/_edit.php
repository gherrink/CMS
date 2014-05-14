<?php
/**
 * @author Alessio Bisgen
 * @copyright 2014
 * @version 0.1
 */
/* 
 * @var GalleryController $this 
 * @var Gallery $model
 * @var BsActiveForm $form
 * @var String $url
 */

$roles = SelectHelper::getSiteRoles();
$languages = SelectHelper::getActiveLanguages();

$selectedRole = MSG::MSITE;
if($model->roleaccess !== null)
	$selectedRole = $model->roleaccess;

$selectedLanguage = Yii::app()->language;
if($model->languageid !== null)
	$selectedLanguage = $model->languageid;


$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
   	'enableAjaxValidation' => false,
	'id' => 'gallery-form',
	'htmlOptions'=>array(
		'onsubmit'=>"return false;",
		'onkeypress'=>" if(event.keyCode == 13){ submitForm('modal', 'content-form', '". $url ."'); } ",
	),
));
$model->oldLabel = $model->label;
?>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'label', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
			<?php echo $form->hiddenField($model, 'oldLabel')?>
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
				echo $form->dropDownListControlGroup($model, 'languageid', $languages, array(
    				'options' => array($selectedLanguage=>array('selected'=>true)),
					'labelOptions'=>array('class'=>'control-label required'),
					'controlOptions'=>array('class'=>''),
				));
			?>
		</div>
	</div>
<?php $this->endWidget(); ?>