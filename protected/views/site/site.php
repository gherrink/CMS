<?php
/**
 * Creates a Site with a DB Content
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/* @property $this SiteController
 * @var $site Site
 * @var $edit boolean		Bearbeitung aktive
 * @var $editable boolean	Bearbeitung inaktiv kann aktiviert werden (normale
 * 							Seitenansicht)
 * 
 * @todo edit und editable
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
				echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array(
					'onclick' => 'showModalAjax("modal", "'.Yii::app()->createAbsoluteUrl('site/update', array('name'=>$site->siteid)).'");',
				));
			?>
		</div>
	</div>
	<hr>
<?php endif;?>

<?php 
	$language = SiteLanguage::model()->findByAttributes(array('siteid'=>$site->siteid, 'languageid'=>Yii::app()->language));
	if($language !== null)
		if($language->head !== null && $language->head !== '')
			echo "<h1>{$language->head}</h1>";
?>

<?php $this->renderPartial('_'.$site->layout, array('site'=>$site, 'edit'=>$edit))?>

<?php if($edit || $editable):?>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<p><?php MsgPicker::msg()->getMessage(MSG::CREATE_USER_TIME, array('user'=>$site->create_userid, 'time'=>$site->create_time))?></p>
		</div>
		<div class="col-sm-6 text-right">
			<p><?php MsgPicker::msg()->getMessage(MSG::UPDATE_USER_TIME, array('user'=>$site->update_userid, 'time'=>$site->create_time))?></p>
		</div>
	</div>
<?php endif;?>