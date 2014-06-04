<?php
/*
 * @var GalleryLanguage[] $galleryLanguages
 * @var BSActiveForm $form
 * @var Gallery $model
 */

?>

<?php 
$counter = 0;
foreach ($galleryLanguages as $galleryLanguage):?>
<div class="row">
	<div class="col-sm-12">
	    <?php 
	        $label = MsgPicker::msg()->getMessage(strtoupper($galleryLanguage->languageid));
	        echo $form->textFieldControlGroup($galleryLanguage, 'head', array(
	            'labelOptions' => array('class' => 'control-label required',
	                'label' => MsgPicker::msg()->getMessage(MSG::GAL_TITLE)." ".$label),
	            'controlOptions' => array('class' => ''),
	            'placeholder' => MsgPicker::msg()->getMessage(MSG::GAL_TITLE),
	            'name' => "GalleryLanguage[$counter][head]",
	        ));
	        echo $form->hiddenField($galleryLanguage, 'languageid', array('name' => "GalleryLanguage[$counter][languageid]"));
	    ?>
	</div>
</div>
<?php 
$counter ++;
endforeach;?>