<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1><?php echo MsgPicker::msg()->getMessage(MSG::PAGE_HOME_WELCOME) ?> <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p><?php echo MsgPicker::msg()->getMessage(MSG::PAGE_HOME) ?></p>

