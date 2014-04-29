<?php
/**
 * Creates a content of a site.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/* 
 * @var ContentController $this
 * @var boolean $editable
 * @var boolean $edit
 * @var SiteContentView $content 
 */
?>

<div class="row">
<?php if($edit || $editable):?>
	<div class="row">
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
			echo BsHtml::button('aSite');
		?>
	</div>
	<hr>
<?php endif;?>

<div <?php echo $edit?'class="edit"':''; ?> id="<?php echo $content->contentid ?>">
	<?php echo $content->text?>
</div>

<?php if($edit):?>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<p><?php MsgPicker::msg()->getMessage(MSG::CREATE_USER_TIME, array('user'=>$content->create_user, 'time'=>$content->create_time))?></p>
		</div>
		<div class="col-sm-6 text-right">
			<p><?php MsgPicker::msg()->getMessage(MSG::UPDATE_USER_TIME, array('user'=>$content->create_user, 'time'=>$content->create_time))?></p>
		</div>
	</div>
<?php endif;?>
</div>