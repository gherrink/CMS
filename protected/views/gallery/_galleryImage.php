<?php

/**
 * @var GalleryController $this
 * @var GalleryView $gallery
 * 
 */

$url = Yii::app()->baseUrl .'/'. $gallery->url;
?>

<div class="img-thumbnail col-xs-6 col-sm-4 col-md-3 col-lg-2" style="border: none;">
	<a href="<?php echo Yii::app()->createAbsoluteUrl('gallery/edit', array('name' => $gallery->label)) ?>">
		<?php echo BsHtml::imageThumbnail($url,$gallery->head, array('style'=>'width: 100%; height: auto;')); ?>
	</a>
	<span><?php echo $gallery->head ?></span>
</div>