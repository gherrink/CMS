<?php
/**
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @version 0.1
 * @copyright 2014
 */

/*
 * @var MenuController $this
 * @var mixed $model
 * @var boolean $editable
 * @var boolean $edit
 * @var string $editLng
 */

if(! isset($editable))
	$editable = false;

if(! isset($edit))
	$edit = false;

if($edit || $editable)
	$edit = true;

if($editLng === '' && array_key_exists('editLng', $_GET))
	$editLng = $_GET['editLng'];
	
?>

<h1><?php MsgPicker::msg()->getMessage(MSG::HEAD_MENU)?></h1>

<div class="row">
	<div class="col-sm-12">
		<?php $this->widget('application.widgets.language.LanguageSelector', array('translate'=>true, 'languageid'=>'name', 'selectedLanguage'=>$editLng));?>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-sm-12">
		<?php $this->renderPartial('_menu', array('menupoints'=>$model, 'edit'=>$edit)); ?>
	</div>
</div>

<?php 
	$this->widget('bootstrap.widgets.BsModal', array(
		'id' => 'modalmenu',
		'header' => 'Modal Heading',
		'content' => '<p>Modal body</p>',
		'footer' => array(
			BsHtml::button('OK', array(
				'data-dismiss' => 'modalmenu',
			))
		),
	));
?>

<script type="text/javascript">
	function cmsMenuChangeUrl()
	{
		$('#Menu_url').val('');
		if($('#Menu_haschilds').is( ":checked" ))
		{
			$('#Menu_url').attr('disabled', 'disabled');
			$('#Menu_url_intern').attr('disabled', 'disabled');
			$("#link-select").attr('disabled', 'disabled');
		}
		else
		{
			$('#Menu_url_intern').removeAttr('disabled');
			if($('#Menu_url_intern').is(':checked'))
			{
				$('#Menu_url').attr('disabled', 'disabled');
				$('#link-select').removeAttr('disabled');
				$('#link-select').removeClass('disabled');
			}
			else
			{
				$('#Menu_url').removeAttr('disabled');
				$('#link-select').attr('disabled', 'disabled');
			}
		}
	}
	
	function cmsMenuInsertLink()
	{
		var link = cmsGetSelectedRow();
		if(link != 'undefined')
		{
			$('#Menu_url').val(link);
			$('#modalmenu').modal('hide');
		}
	}

	function cmsMenuInsertParent()
	{
		var link = cmsGetSelectedRow();
		if(link != 'undefined')
		{
			params = link.split("***");
			$('#Menu_parent_menuid').val(params[0]);
			$('#Menu_parent_menu').val(params[1]);
			$('#modalmenu').modal('hide');
		}
	}

	function cmsMenuRemoveParent()
	{
		$('#Menu_parent_menuid').val('');
		$('#Menu_parent_menu').val('');
	}

	function cmsMenuChangIcon(icon)
	{
		$('#Menu_icon').val(icon);
		$('#menuicon').removeClass().addClass('control-label glyphicon ' + icon);
		$('#modalmenu').modal('hide');
	}

	function cmsMenuRemoveIcon()
	{
		$('#Menu_icon').val('');
		$('#menuicon').removeClass();
		$('#modalmenu').modal('hide');
	}

	function cmsMenuSetArrows()
	{
		$(".list-group-item .pull-right .<?php echo BsHtml::GLYPHICON_ARROW_UP ?>").parent().removeClass('disabled');
		$(".list-group-item .pull-right .<?php echo BsHtml::GLYPHICON_ARROW_DOWN ?>").parent().removeClass('disabled');
		$(".list-group-item:nth-last-of-type(2) >.pull-right .<?php echo BsHtml::GLYPHICON_ARROW_DOWN ?>").parent().addClass('disabled');
		$(".list-group-item:first-child >.pull-right .<?php echo BsHtml::GLYPHICON_ARROW_UP ?>").parent().addClass('disabled');
	}
</script>