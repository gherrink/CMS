<?php
/**
 * Creates all contents in one col.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 *
 * @var Site $site
 * @var boolean $edit
 * @var int $col
 */

$language = Yii::app()->language;
$contents = SiteContentView::model()->findAllBySql("SELECT * FROM SiteContentView WHERE siteid = '{$site->siteid}' AND languageid = '$language' AND col = $col AND {$this->getRoleaccessSQLWhere()} ORDER BY position");

foreach ($contents as $content)
	$this->renderpartial('_content', array('content'=>$content, 'edit'=>$edit));
?>