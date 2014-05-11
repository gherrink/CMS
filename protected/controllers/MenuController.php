<?php
/**
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 */
class MenuController extends CRUDController
{
	protected $viewColumns = array(
			'label',
			array(
				'name' => 'roleaccess',
				'type' => 'raw',
				'value' => 'MsgPicker::msg()->getMessage($data->roleaccess)',
			),
	);
	protected $rowExpression = '["id" => $data->menuid ."***". $data->label]';
	
	public function findModel($name, $editLng)
	{
		if($this->action->id === 'read')
		{
			$_GET['editLng'] = $name;
			return Menu::model()->findAll("languageid = '$name' AND parent_menuid IS NULL AND {$this->getRoleaccessSQLWhere()} ORDER BY position");
		}
		else
			return Menu::model()->findByAttributes(array('menuid'=>$name, 'languageid'=>$editLng));
	}
	
	public function getModelName()
	{
		return 'Menu';
	}
	
	protected function getParamsRead()
	{
		return array();
	}
	
	protected function modelCreate(CActiveRecord $model)
	{
		$model->menuid = Yii::app()->keygen->getUniquKey();
		if($model->insert())
		{
			if($model->parent_menuid === null)
				$menu['before'] = '#menuitem';
			else
				$menu['before'] = '#menuitem-'. $model->parent_menuid;
			$menu['html'] = $this->renderPartial('_menupoint', array('menupoint'=>$model, 'edit'=>true), true);
			$menu['modalhide'] = 'modal';
			echo json_encode($menu);
			Yii::app()->end();
		}
	}
	
	protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
	{
		$dbModel->roleaccess = $model->roleaccess;
		$dbModel->label = $model->label;
		$dbModel->url_intern = $model->url_intern;
		$dbModel->url = $model->url;
		$dbModel->site = $model->site;
		$dbModel->icon = $model->icon;
		$dbModel->parent_menuid = $model->parent_menuid;
		
		if($dbModel->update())
		{
			if($model->parent_menuid !== $model->oldparent_menuid)
			{
				$menu['remove'] = '#'.$dbModel->menuid;
				if($model->parent_menuid === null)
					$menu['before'] = '#menuitem';
				else
					$menu['before'] = '#menuitem-'.$model->parent_menuid;
			}
			else 
				$menu['replace'] = '#'.$dbModel->menuid;
			
			$menu['html'] = $this->renderPartial('_menupoint', array('menupoint'=>$dbModel, 'edit'=>true), true);
			$menu['modalhide'] = 'modal';
			echo json_encode($menu);
			Yii::app()->end();
		}
	}
	
	protected function modelDelete(CActiveRecord $model)
	{
		$selector = '#'. $model->menuid;
		if($model->delete())
		{
			$menu['remove'] = $selector;
			echo json_encode($menu);
			Yii::app()->end();
		}
	}
	
	public function actionIconView()
	{
		$icon['header'] = MsgPicker::msg()->getMessage(MSG::HEAD_MENU_ICONSELECT);
		$icon['body'] = $this->renderPartial('_iconselect', array(), true);
		$icon['footer'] = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array('onclick'=>"$('#modalmenu').modal('hide');"));
		echo json_encode($icon);
	}
	
	public function actionTest()
	{
		print_r($_GET);
	}
}