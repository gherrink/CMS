<?php
/**
 * Creates a content of a site.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/* 
 * @var ContentController $this
 * @var Content $model
 * @var boolean $editable
 * @var boolean $edit
 * @var boolean $onSite
 */

if(! isset($edit))
	$edit = false;

if(! isset($onSite))
	$onSite = false;

if($edit === true && $editable === true)
	$editable = false;
?>

<?php if($edit || $editable):?>
	<div class="row">
		<div class="col-sm-12">
			<?php
				if($editable)
					echo BsHtml::linkButton(MsgPicker::msg()->getMessage(MSG::BTN_EDIT), array(
						'url' => Yii::app()->createAbsoluteUrl('content/edit', array('name'=>$model->label))
					));
					
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array(
					'onclick' => 'showModalAjax("modal", "'.Yii::app()->createAbsoluteUrl('content/update', array('name'=>$model->label)).'");',
				));
				
				$urlDelete = Yii::app()->createAbsoluteUrl('content/delete', array('name'=>$model->label));
				$urlQuestionDelete = Yii::app()->createAbsoluteUrl('site/question', array(
					'head'=>MSG::HEAD_QUESTION_REALYDELETE,
					'question'=>MSG::QUESTION_DELEATE_CONTENT,
				));
				$json = json_encode(array('buttons'=>array(
					MSG::BTN_YES => "deleteAjax('$urlDelete'); $('#modalmsg').modal('hide');",
					MSG::BTN_NO => "$('#modalmsg').modal('hide');",
				)));
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_DELETE), array(
					'onclick'=>"showModalAjax('modalmsg', '$urlQuestionDelete', $json);")
				);
				
				if($onSite)
					echo BsHtml::button('delFromSite');
				else 
					echo BsHtml::button('add2Site');
			?>
		</div>
	</div>
	<hr>
<?php endif;?>

<div <?php echo $edit?'class="edit"':''; ?> id="<?php echo $model->contentid ?>">
	<?php echo $model->text?>
</div>

<?php if($edit):?>
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