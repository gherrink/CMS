<?php
/**
 * Creates a Site with a DB Content
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/* 
 * @var SiteController $this
 * @var Site $model
 * @var boolean $edit		
 * @var boolean $editable
 * @var string $editLng
 */

if(! isset($edit))
	$edit = false;

if($edit === true && $editable === true)
	$editable = false;
?>

<?php if($edit || $editable):?>
	<div class="row">
		<div class="col-sm-12 btn-group">
			<?php 
				if($editable)
					echo BsHtml::linkButton(MsgPicker::msg()->getMessage(MSG::BTN_EDIT), array(
						'url' => Yii::app()->createAbsoluteUrl('site/edit', array('name'=>$model->label))
					));
				else 
					echo BsHtml::linkButton(MsgPicker::msg()->getMessage(MSG::BTN_READ), array(
						'url' => Yii::app()->createAbsoluteUrl('site/read', array('name'=>$model->label))
					));
				
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array(
					'onclick' => 'cmsShowModalAjax("modal", "'.Yii::app()->createAbsoluteUrl('site/update', array('name'=>$model->label)).'");',
				));
				
				$urlDelete = Yii::app()->createAbsoluteUrl('site/delete', array('name'=>$model->label));
				$urlQuestionDelete = Yii::app()->createAbsoluteUrl('site/question', array(
					'head'=>MSG::HEAD_QUESTION_REALYDELETE,
					'question'=>MSG::QUESTION_DELETE_SITE,
				));
				$json = json_encode(array('buttons'=>array(
					MSG::BTN_YES => "cmsAjax('$urlDelete'); $('#modalmsg').modal('hide');",
					MSG::BTN_NO => "$('#modalmsg').modal('hide');",
				)));
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_DELETE), array(
					'onclick'=>"cmsShowModalAjax('modalmsg', '$urlQuestionDelete', $json);")
				);
				$this->widget('application.widgets.language.LanguageSelector', array('translate'=>true, 'languageid'=>'editLng', 'selectedLanguage'=>$editLng));
			?>
		</div>
	</div>
	<hr>
<?php endif;?>

<?php 
	if($editLng !== '')
		$lng = $editLng;
	else
		$lng = Yii::app()->language;
	
	$language = SiteLanguage::model()->findByAttributes(array('siteid'=>$model->siteid, 'languageid'=>$lng));
	if($language !== null)
		if($language->head !== null && $language->head !== '')
			echo "<h1>{$language->head}</h1>";
?>

<?php $this->renderPartial('_'.$model->layout, array('site'=>$model, 'edit'=>$edit, 'editLng'=>$editLng))?>

<?php if($edit || $editable):?>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<p><?php echo MsgPicker::msg()->getMessage(MSG::CREATE_USER_TIME, array('user'=>$model->create_userid, 'time'=>$model->create_time))?></p>
		</div>
		<div class="col-sm-6 text-right">
			<p><?php echo MsgPicker::msg()->getMessage(MSG::UPDATE_USER_TIME, array('user'=>$model->update_userid, 'time'=>$model->update_time))?></p>
		</div>
	</div>
<?php endif;?>
<?php 
	if($edit)
		$this->renderPartial('../content/_aloha');
?>