<?php

/*
 * @var GalleryController $this
 * @var GalleryView[] $models
 * @var boolean $edit
 * @var boolean $editable
 * @var string $editLng
 */
?>
<h1><?php echo MsgPicker::msg()->getMessage(MSG::MP_GALLERY).": ".$head ?></h1>

<!-- Menü-Buttons -->
<?php

//Erstellen-Funktion
echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CREATE), array(
		'onclick' => 'cmsShowModalAjax("modal", "' . Yii::app()->createAbsoluteUrl('gallery/create') . '");',
));

//Fall wir uns in der Galerie befinden

if($model !== null)
{
	//Bearbeiten-Funktion
	echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPDATE), array(
			'onclick' => 'cmsShowModalAjax("modal", "' . Yii::app()->createAbsoluteUrl('gallery/update', array(
					'name' => $model->label)) . '");',
	));

	//Lösch-Funktion
	$urlDelete = Yii::app()->createAbsoluteUrl('gallery/delete', array(
			'name' => $model->label));
	$urlQuestionDelete = Yii::app()->createAbsoluteUrl('gallery/question', array(
			'head' => MSG::HEAD_QUESTION_REALYDELETE,
			'question' => MSG::QUESTION_DELETE_GALLERY,
	));
	$json = json_encode(array('buttons' => array(
			MSG::BTN_YES => "cmsAjax('$urlDelete'); $('#modalmsg').modal('hide');",
			MSG::BTN_NO => "$('#modalmsg').modal('hide');",
	)));
	echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_DELETE), array(
			'onclick' => "cmsShowModalAjax('modalmsg', '$urlQuestionDelete', $json);")
	);
	//ENDE Lösch-Funktion
	echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_UPLOAD), array(
		'onclick' => Yii::app()->createAbsoluteUrl('image/upload')));
}
?>

<!-- Gallery-Elemente mit Thumbnails -->
<div class="row">

	<?php 
	foreach ($models as $gallery)
	{
		$this->renderPartial('_galleryImage', array('gallery'=> $gallery));
	}
	?>
</div>

