<?php
/**
 * Creates a Site with a DB Content
 * @author Lukas Schreck
 * @copyright 2014
 * @version 0.1
 */

/*
 * @var $DINO
 * @var $ID
*/

?>

<h1>Neuigkeiten</h1>

<?php
//Button um Neuigkeiten hinzuzufügen
	echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_NEWS), array('onclick'=>'cmsShowModalAjax("modal", "'.Yii::app()->createAbsoluteUrl('news/create').'");'));
	
	$this->renderPartial('_news', array('ID'=>Yii::app()->user->getID()));

//Buttons am Seitenende	
	echo BsHtml::pager(array(
			array(
					'label' => '<- Älter',
					'url' => '#'
			),
			array(
					'label' => 'Jünger ->',
					'url' => '#'
			)
	));

	
?>
<br>
<br>

<?php 
$this->widget('application.widgets.aloha.Aloha', array(
		'selector' => '.edit',
		'plugins' => array(
				'load' => 'common/ui,common/format,common/highlighteditables,custom/save',
				'format' => array('config' => array('b','i','sub','sup','p','h2','h3','h4','h5','h6'))
		),
));
?>

<script type="text/javascript">
// textformatierungsding
function alohaSave()
{
	var news = Aloha.activeEditable.getContents();
	var newstId = Aloha.activeEditable.obj[0].id;

	var request = jQuery.ajax({
		url: '<?php echo Yii::app()->createAbsoluteUrl('news/saveText'); ?>?name='+newsId,
		type: "POST",
		data: {
			content : content
		},
		success: function(data, textStatus, jqXHR){
		},
		error: function(jqXHR, textStatus, errorThrown) {
			showErrorModal(modelid, jqXHR, textStatus, errorThrown);
		},
		dataType: "html"
	});
}
</script>


