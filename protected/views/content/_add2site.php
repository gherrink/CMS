<?php
/**
 * Creates the javascript for the Aloha-Editor.
* @author Maurice Busch
* @copyright 2014
* @version 0.1
*/

/*
 * @var ContentController $this
 * @var Site $model
 */

if(! isset($model))
	$model = new Site('search');
	
$criteria=new CDbCriteria;

$criteria->compare('label', $model->label, true);
$criteria->compare('roleaccess', $model->roleaccess, true);

$data = new CActiveDataProvider('Site', array(
	'criteria' => $criteria,
	'pagination' => array(
		'pageSize' => 8,
 		'route'=>'content/updateAdd2Site'
	),
 	'sort'=>array(
 		'route'=>'content/updateAdd2Site'
 	)
));

$this->widget('bootstrap.widgets.BsGridView', array(
//$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'site-table',
 	'type' => array(BsHtml::GRID_TYPE_HOVER),
	'dataProvider' => $data,
	'filter' => $model,
	'pager'=>array(
		'maxButtonCount'=>7,
	),
	'selectableRows'=>1,
	'rowHtmlOptionsExpression' => '["name" => $data->label]',
	
	'ajaxUpdate' => 'site-table',
	'ajaxUrl' => Yii::app()->createUrl( 'content/updateAdd2Site' ),
	
	'columns' => array(
		'label',
		array(
			'name' => 'roleaccess',
			'type' => 'raw',
			'value' => 'MsgPicker::msg()->getMessage($data->roleaccess)',
		),
	),
));

?>

<script type="text/javascript">
function addContent2Site()
{
	var site = $('#site-table .selected').attr('name');
	var content = location.search.split('name=')[1];
	doAjax('<?php echo Yii::app()->createAbsoluteUrl('content/addContent2Site')?>?site='+site+'&content='+content);
}
</script>
