<?php

echo "<h1>Galerie</h1>";

$path = Yii::app()->basePath.'/../images';


$contentOfImageFolder = scandir($path);
$url = Yii::app()->baseUrl;

echo '<div class="row" style="">';
foreach ($contentOfImageFolder as $image)
{
	if($image !== '.' && $image !== '..')
		$this->renderPartial('_image', array('url'=> $url . '/images/'. $image));
}
echo '</div>';

?>
