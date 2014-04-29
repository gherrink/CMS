<?php
/**
 * Creates a content of a site.
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */

/*
 * @var ContentController $this
 * @var boolean $editable
 * @var boolean $edit
 * @var Content $model
 */

$this->renderPartial('_content', array('editable'=>$editable, 'edit'=>$edit, 'model'=>$model));
$this->renderPartial('_aloha');
?>