<?php
/**
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 * 
 * @var SiteLanguage $model
 * @var BsActiveForm $form
 * @var Integer $counter
 */

if(! isset($counter))
	$counter = 1;

$label = MsgPicker::msg()->getMessage(strtoupper($model->languageid));
?>

<div class="row">
	<div class="col-sm-10">
		<?php 
			echo $form->textFieldControlGroup($model, 'head',
				array(
					'labelOptions'=>array('class'=>'control-label required', 'label'=>$label),
					'controlOptions'=>array('class'=>''),
					'placeholder'=>$label,
					'name'=>"SiteLanguage[$counter][head]",
				)
			);
			$form = new BsActiveForm();
			echo $form->hiddenField($model, 'languageid', array('name'=>"SiteLanguage[$counter][languageid]"));
		?>
	</div>
	<div class="col-sm-2">
		<?php echo BsHtml::button('', array('icon'=>BsHtml::GLYPHICON_TRASH, 'onclick'=>'deleteLanguage("'.$model->languageid.'")'))?>
	</div>
</div>