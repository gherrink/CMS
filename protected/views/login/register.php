<?php
/**
 * Erstellen des Registrierungsformulars.
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 */
/* 
 * @var $this LoginController
 * @var $model User
 * @var $form BsActiveForm
 */

$this->breadcrumbs=array(
	MsgPicker::msg()->getMessage(MSG::HEAD_LOGIN)=>array('/login'),
	MsgPicker::msg()->getMessage(MSG::HEAD_REGISTER),
);
?>
<h1><?php MsgPicker::msg()->getMessage(MSG::HEAD_REGISTER)?></h1>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
    	'enableAjaxValidation' => true,
		'id' => 'register-form',
		'action' => array('login/register'),
	));
?>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'userid', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'firstname', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'lastname', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->passwordFieldControlGroup($model, 'password', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $form->passwordFieldControlGroup($model, 'password_repead', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->emailFieldControlGroup($model, 'mail', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<?php if(CCaptcha::checkRequirements()): ?>
		<div class="form-group verification <?php echo ($model->hasErrors('verifyCode'))?'has-error':'';?>">
			<div class="row">
				<div class="col-sm-6">
					<?php echo $form->labelEx($model,'verifyCode'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<?php $this->widget('CCaptcha'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<?php echo $form->textField($model,'verifyCode'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 help-block">
					<?php echo $form->error($model,'verifyCode'); ?>
					<?php echo MsgPicker::msg()->getMessage(MSG::VERIFY_INFO)?>
				</div>
			</div>
		</div>
	<?php endif; ?>
 	
	<?php echo BsHtml::submitButton(MsgPicker::msg()->getMessage(MSG::BTN_REGISTER)); ?>
 
<?php $this->endWidget(); ?>