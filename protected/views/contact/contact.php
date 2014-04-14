<?php
/**
 * Erstellen eines Kontaktformulars.
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 * 
 * @var $this ContactController
 * @var $model ContactForm
 * @var $form BsActiveForm
 */

$this->breadcrumbs=array(
	MsgPicker::msg()->getMessage(MSG::HEAD_CONTACT),
);
?>

<h1><?php echo MsgPicker::msg()->getMessage(MSG::HEAD_CONTACT)?></h1>

<p><?php echo MsgPicker::msg()->getMessage(MSG::CONTACT_INFO)?></p>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
    	'enableAjaxValidation' => false,
		'id' => 'contact-form',
		'action' => array('contact/contact'),
	));
?>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'name', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $form->emailFieldControlGroup($model, 'mail', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'subject', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php echo $form->textAreaControlGroup($model, 'body', array('style'=>'height: 300px;', 'labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
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
	
	<div class="row">
		<div class="col-sm-6">
			<?php echo BsHtml::submitButton(MsgPicker::msg()->getMessage(MSG::BTN_OK)); ?>
		</div>
	</div>
<?php $this->endWidget();?>