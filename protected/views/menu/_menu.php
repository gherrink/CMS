<?php
/**
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @version 0.1
 * @copyright 2014
 */

/*
 * @var MenuController $this
 * @var array $menupoints
 * @var boolean $edit
 * @var string $id
 */
?>
<div class="list-group<?php echo (isset($id))?' submenu" id="sub-'.$id.'" style="display: none;':''?>">
	<?php 
		foreach ($menupoints as $menupoint)
		{
			$this->renderPartial('_menupoint', array('menupoint'=>$menupoint, 'edit'=>$edit, 'lastpos'=>$menupoint->countOnLevel() -1));
		}
	?>
	<span id="menuitem<?php echo (isset($id))?'-'.$id:''?>"></span>
	<div class="list-group-item">
		<?php 
			if(isset($id))
				$url = Yii::app()->createAbsoluteUrl('menu/create', array('parent'=>$id));
			else 
				$url = Yii::app()->createAbsoluteUrl('menu/create');
			
			echo BsHtml::button('', array(
				'onclick' => "cmsShowModalAjax('modal', '$url');",
				'icon' => BsHtml::GLYPHICON_PLUS,
			));
		?>
	</div>
</div>