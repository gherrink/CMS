<?php
/**
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 */
class ContentController extends CRUDController
{
	public function findModel($name)
	{
		return Content::model()->findByAttributes(array('label'=>$name));
	}
	
	public function getModelName()
	{
		return 'Content';
	}
	
	protected function getParamsRead()
	{
		return array();
	}
	
	protected function testMoadelRead(CActiveRecord $model)
	{
		return true;
	}
	
	/**
	 *
	 * @param CActiveRecord $model
	 * @return string Error
	*/
	protected function modelCreate(CActiveRecord $model)
	{
		
	}
	
	/**
	 *
	 * @param CActiveRecord $model
	 * @param CActiveRecord $dbModel
	 * @return string Error
	*/
	protected abstract function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel);
	
	protected abstract function modelDelete(CActiveRecord $model);
}