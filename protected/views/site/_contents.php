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
	$this->renderPartial('../content/_content', array('model'=>$content, 'edit'=>$edit, 'editable'=>false, 'site'=>$site->siteid));

if($edit)
{
	$url = Yii::app()->createAbsoluteUrl('content/view', array('head'=>MSG::HEAD_CONTENT_ADD2SITE));
	$addUrl = Yii::app()->createAbsoluteUrl('content/addContent2Site', array('col'=>$col, 'site'=>$site->label));
	$json = json_encode(array('buttons'=>array(
		MSG::BTN_EXIT => "$('#modal').modal('hide');",
		MSG::BTN_SITE_NEWCONTENT => "cmsAjax('$addUrl&content=' + cmsGetSelectedRow());",
	)));
	echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_SITE_NEWCONTENT), array(
			'onclick'=>"cmsShowModalAjax('modal', '$url', $json);"
	));
}
?>