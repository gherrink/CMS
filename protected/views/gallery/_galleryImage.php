<?php

/**
 * @var GalleryController $this
 * @var GalleryView $gallery
 */
?>

<div class="img-thumbnail col-xs-6 col-sm-4 col-md-3 col-lg-2" style="border: none;">
	<?php echo BsHtml::imageThumbnail($gallery->url,$gallery->head, array('style'=>'width: 100%; height: auto;'));//, array('style'=>'width: 100px; height: auto;') ?>
	<span><?php echo $gallery->head ?></span>
</div>