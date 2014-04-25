<?php
/**
 * Erstellen des Loginformulars
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 */
/*
 * @var $this LoginController
 * @var $model Usr
 * @var $form BsActiveForm
 */

$this->breadcrumbs=array(
	MsgPicker::msg()->getMessage(MSG::HEAD_LOGIN),
);
?>
<h1><?php MsgPicker::msg()->getMessage(MSG::HEAD_LOGIN)?></h1>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
    	'enableAjaxValidation' => false,
		'id' => 'login-form',
		'action' => array('login/login'),
	));
?>
	<div class="row">
		<div class="col-sm-4">
			<?php echo $form->textFieldControlGroup($model, 'userid', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<?php echo $form->passwordFieldControlGroup($model, 'password', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<?php echo BsHtml::submitButton(MsgPicker::msg()->getMessage(MSG::BTN_OK)); ?>
			<?php echo BsHtml::linkButton(MsgPicker::msg()->getMessage(MSG::BTN_REGISTER), array(
					'url' => array('login/register'),
				));
			?>
		</div>
	</div>
<?php $this->endWidget();?>