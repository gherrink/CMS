<?php
/**
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 * 
 * @var SiteController $this 
 * @var Site $model
 * @var BsActiveForm $form
 */

$roles = array('MSITE' => 'moderator');
$layouts = array('col01' => 'Eine Spalte');

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
   	'enableAjaxValidation' => true,
	'id' => 'site-form',
	'action' => array('site/edit'),
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
    				'options' => array($selectRole=>array('selected'=>true)),
					'labelOptions'=>array('class'=>'control-label required'),
					'controlOptions'=>array('class'=>''),
				));
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<?php
				echo $form->dropDownListControlGroup($model, 'layout', $layouts, array(
    				'options' => array($selectLayout=>array('selected'=>true)),
					'labelOptions'=>array('class'=>'control-label required'),
					'controlOptions'=>array('class'=>''),
				));
			?>
		</div>
	</div>
<?php $this->endWidget(); ?>