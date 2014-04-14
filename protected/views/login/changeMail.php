<?php

/**
 * Creats a Formular to change the mail.
 * 
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 * 
 * @var $this LoginController
 * @var $model User
 * @var $form BsActiveForm
 */

$this->breadcrumbs=array(
	MsgPicker::msg()->getMessage(MSG::HEAD_LOGIN)=>array('/login'),
	MsgPicker::msg()->getMessage(MSG::HEAD_CHANGEMAIL),
);
?>
<h1><?php MsgPicker::msg()->getMessage(MSG::HEAD_CHANGEMAIL)?></h1>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
    	'enableAjaxValidation' => true,
		'id' => 'changeMail-form',
		'action' => array('login/changeMail'),
	));
?>
 
	<fieldset>
		<?php echo $form->textFieldControlGroup($model, 'userid'); ?>
		<?php echo $form->passwordFieldControlGroup($model, 'password'); ?>
		<?php echo $form->emailFieldControlGroup($model, 'mail'); ?>
	</fieldset>
 
	<?php echo BsHtml::submitButton(MsgPicker::msg()->getMessage(MSG::BTN_OK)); ?>
 
<?php $this->endWidget(); ?>