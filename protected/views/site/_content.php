<?php
/**
 * Creates a content of a site.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 * 
 * @var boolean $edit
 * @var SiteContentView $content 
 */
?>

<div class="row">
<?php if($edit):?>
	<div class="row">
		<?php echo BsHtml::linkButton()?>
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