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


$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
   	'enableAjaxValidation' => false,
	'id' => 'gallery-form',
	'htmlOptions'=>array(
		'onsubmit'=>"return false;",
		'onkeypress'=>" if(event.keyCode == 13){ submitForm('modal', 'content-form', '". $url ."'); } ",
	),
));
?>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $form->textFieldControlGroup($model, 'label', array('labelOptions'=>array('class'=>'control-label required'), 'controlOptions'=>array('class'=>''))); ?>
		</div>
	</div>
	
	
<?php $this->endWidget(); ?>