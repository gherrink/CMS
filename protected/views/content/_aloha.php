<?php
/**
 * Creates a content of a site.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/*
 * @var ContentController $this
 */

$this->widget('application.widgets.aloha.Aloha', array(
	'selector' => '.edit',
	'plugins' => array(
		'load' => 'common/ui,common/format,common/highlighteditables,custom/save',
		'format' => array('config' => array('b','i','sub','sup','p','h2','h3','h4','h5','h6'))
	),
));
?>

<script type="text/javascript">
function alohaSave()
{
	var content = Aloha.activeEditable.getContents();
	var contentId = Aloha.activeEditable.obj[0].id;
	
// 	// textarea handling -- html id is "xy" and will be "xy-aloha" for the aloha editable
// 	if ( contentId.match(/-aloha$/gi) ) {
// 		contentId = contentId.replace( /-aloha/gi, '' );
// 	}

	var request = jQuery.ajax({
		url: '<?php echo Yii::app()->createAbsoluteUrl('content/saveText'); ?>?name='+contentId,
		type: "POST",
		data: {
			content : content
		},
		dataType: "html"
	});

	request.done(function(msg) {
		
	});

	request.error(function(jqXHR, textStatus) {
		alert( jqXHR.responseText );
	});
}
</script>
