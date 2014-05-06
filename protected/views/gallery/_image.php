<?php

/**
 * @var GalleryController $this
 * @var string $url
 */
?>

<div class="img-thumbnail col-xs-6 col-sm-4 col-md-3 col-lg-2" style="border: none;">
	<?php echo BsHtml::imageThumbnail($url,'SceneryRules', array('style'=>'width: 100%; height: auto;'));//, array('style'=>'width: 100px; height: auto;') ?>
	<span>Beschreibung</span>
</div>