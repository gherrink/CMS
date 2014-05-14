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

<div class="row">
	<?php 
	foreach ($model as $gallery)
	{
		$this->renderPartial('_galleryImage', array('gallery'=> $gallery));
	}
	?>
</div>

