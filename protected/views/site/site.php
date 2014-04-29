<?php
/**
 * Creates a Site with a DB Content
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/* 
 * @var $this SiteController
 * @var $model Site
 * @var $edit boolean		
 * @var $editable boolean
 */

if($edit === null || ! $editable)
	$edit = false;

if($edit === true && $editable === true)
	$editable = false;
?>

<?php if($edit || $editable):?>
	<div class="row">
		<div class="col-sm-12">
			<?php 
				if($editable)
					echo BsHtml::linkButton(MsgPicker::msg()->getMessage(MSG::BTN_EDIT), array(
						'url' => Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$model->label))
					));
				
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array(
					'onclick' => 'showModalAjax("modal", "'.Yii::app()->createAbsoluteUrl('site/update', array('name'=>$model->label)).'");',
				));
				
				$urlDelete = Yii::app()->createAbsoluteUrl('site/delete', array('name'=>$model->label));
				$urlQuestionDelete = Yii::app()->createAbsoluteUrl('site/question', array(
					'head'=>MSG::HEAD_QUESTION_REALYDELETE,
					'question'=>MSG::QUESTION_DELEATE_SITE,
				));
				$json = json_encode(array('buttons'=>array(
					MSG::BTN_YES => "deleteAjax('$urlDelete'); $('#modalmsg').modal('hide');",
					MSG::BTN_NO => "$('#modalmsg').modal('hide');",
				)));
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_DELETE), array(
					'onclick'=>"showModalAjax('modalmsg', '$urlQuestionDelete', $json);")
				);
			?>
		</div>
	</div>
	<hr>
<?php endif;?>

<?php 
	$language = SiteLanguage::model()->findByAttributes(array('siteid'=>$model->siteid, 'languageid'=>Yii::app()->language));
	if($language !== null)
		if($language->head !== null && $language->head !== '')
			echo "<h1>{$language->head}</h1>";
?>

<?php $this->renderPartial('_'.$model->layout, array('site'=>$model, 'edit'=>$edit))?>

<?php if($edit || $editable):?>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<p><?php MsgPicker::msg()->getMessage(MSG::CREATE_USER_TIME, array('user'=>$model->create_userid, 'time'=>$model->create_time))?></p>
		</div>
		<div class="col-sm-6 text-right">
			<p><?php MsgPicker::msg()->getMessage(MSG::UPDATE_USER_TIME, array('user'=>$model->update_userid, 'time'=>$model->create_time))?></p>
		</div>
	</div>
<?php endif;?>
<?php 
	if($edit)
		$this->renderPartial('../content/_aloha');
?>