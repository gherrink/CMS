<?php

/*
 * @var GalleryController $this
 * @var GalleryView[] $model
 * @var boolean $edit
 * @var boolean $editable
 * @var string $editLng
 */
?>
<h1>Gallery</h1>

<!-- Menü-Buttons -->
<?php

echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_CREATE), array(
		'onclick' => 'cmsShowModalAjax("modal", "' . Yii::app()->createAbsoluteUrl('gallery/create') . '");',
));
// 	$this->renderPartial('_galleryImage', array('ID'=>Yii::app()->user->getID()));
	
?>

<!-- Gallery-Elemente mit Thumbnails -->
<div class="row">

	<?php 
	foreach ($models as $gallery)
	{
		$this->renderPartial('_galleryImage', array('gallery'=> $gallery));
		echo"Test";
	}
	?>
</div>

