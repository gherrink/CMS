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
 * @var boolean $site
 */

if(! isset($edit))
	$edit = false;

if(! isset($site))
	$site = false;

if($edit === true && $editable === true)
	$editable = false;
?>

<?php if($edit || $editable):?>
	<div class="row">
		<div class="col-sm-12 btn-group">
			<?php
				if($editable)
					echo BsHtml::linkButton(MsgPicker::msg()->getMessage(MSG::BTN_EDIT), array(
						'url' => Yii::app()->createAbsoluteUrl('content/edit', array('name'=>$model->label))
					));
					
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array(
					'onclick' => 'cmsShowModalAjax("modal", "'.Yii::app()->createAbsoluteUrl('content/update', array('name'=>$model->label)).'");',
				));
				
				$urlDelete = Yii::app()->createAbsoluteUrl('content/delete', array('name'=>$model->label));
				$urlQuestionDelete = Yii::app()->createAbsoluteUrl('site/question', array(
					'head'=>MSG::HEAD_QUESTION_REALYDELETE,
					'question'=>MSG::QUESTION_DELETE_CONTENT,
				));
				$json = json_encode(array('buttons'=>array(
					MSG::BTN_YES => "cmsAjax('$urlDelete'); $('#modalmsg').modal('hide');",
					MSG::BTN_NO => "$('#modalmsg').modal('hide');",
				)));
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_DELETE), array(
					'onclick'=>"cmsShowModalAjax('modalmsg', '$urlQuestionDelete', $json);",
				));
				
				if($site)
				{
					$urlDelete = Yii::app()->createAbsoluteUrl('site/deleteContent', array('con'=>$model->contentid, 'site'=>$site, 'lng'=>$model->languageid));
					$urlQuestionDelete = Yii::app()->createAbsoluteUrl('site/question', array(
							'head'=>MSG::HEAD_QUESTION_REALYDELETE,
							'question'=>MSG::QUESTION_DELETE_SITECONTENT,
					));
					$json = json_encode(array('buttons'=>array(
							MSG::BTN_YES => "cmsAjax('$urlDelete'); $('#modal').modal('hide');",
							MSG::BTN_NO => "$('#modal').modal('hide');",
					)));
					echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_SITE_DELETECONTENT), array(
						'onclick' => "cmsShowModalAjax('modal', '$urlQuestionDelete', $json);",
					));
				}
				else 
				{
					$url = Yii::app()->createAbsoluteUrl('site/view', array('head'=>MSG::HEAD_CONTENT_ADD2SITE));
					$addUrl = Yii::app()->createAbsoluteUrl('content/addContent2Site', array('content'=>$model->label));
					$json = json_encode(array('buttons'=>array(
						MSG::BTN_CONTENT_ADD2SITE => "cmsAjax('$addUrl&site=' + cmsGetSelectedRow());",
						MSG::BTN_EXIT => "$('#modal').modal('hide');",
					)));
					echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CONTENT_ADD2SITE), array(
						'onclick'=>"cmsShowModalAjax('modal', '$url', $json);"
					));
				}
			?>
		</div>
	</div>
	<hr>
<?php endif;?>
<?php if($edit):?>
<div class="edit" id="<?php echo $model->contentid ?>">
	<?php echo $model->text?>
</div>
<?php else:?>
<div>
	<?php echo $model->text?>
</div>
<?php endif;?>

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