<?php
/**
 * Creates all contents in one col.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */
/*
 * @var Site $site
 * @var boolean $edit
 * @var string $editLng
 * @var int $col
 */

if($editLng === '')
	$language = Yii::app()->language;
else
	$language = $editLng;

$contents = SiteContentView::model()->findAllBySql("SELECT * FROM SiteContentView WHERE siteid = '{$site->siteid}' AND languageid = '$language' AND col = $col AND {$this->getRoleaccessSQLWhere()} ORDER BY position");

foreach ($contents as $content)
	$this->renderPartial('../content/_content', array('model'=>$content, 'edit'=>$edit, 'editable'=>false, 'onSite'=>true));

if($edit)
	echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_NEW_CONTENT), array('onclick'=>'addNewContent()'))
?>

<script type="text/javascript">
	function addNewContent()
	{

	}
</script>