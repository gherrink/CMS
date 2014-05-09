<?php
/**
 * Creates a View for all DB-models
* @author Maurice Busch
* @copyright 2014
* @version 0.1
*/

/*
 * @var CRUDController $this
 * @var CActiveRecord $model
 */
	
$this->widget('bootstrap.widgets.BsGridView', array(
	'id' => $this->viewid,
 	'type' => array(BsHtml::GRID_TYPE_HOVER),
	'dataProvider' => $model->search(),
	'filter' => $model,
	'pager'=>array(
		'maxButtonCount'=>7,
	),
	'selectableRows'=> $this->selectableRows,
	'rowHtmlOptionsExpression' => $this->rowExpression,
	
	'ajaxUpdate' => $this->viewid,
	'ajaxUrl' => Yii::app()->createAbsoluteUrl( $this->getID().'/viewUpdate' ),
	
	'columns' => $this->viewColumns,
));

?>
