<?php
class ModelCheck
{
	private $model;
	private $modelName;
	private $role;
	private $ajax;
	
	public function __construct($model, $modelName, $role, $ajax='')
	{
		$this->model = $model;
		$this->modelName = $modelName;
		$this->role = $role;
		$this->ajax = $ajax;
	}
	
	public function getModel()
	{
		return $this->model;
	}
	
	public function getModelName()
	{
		return $this->modelName;
	}
	
	public function getRole()
	{
		return $this->role;
	}
	
	public function getAjax()
	{
		return $this->ajax;
	}
}