<?php
class Aloha extends CWidget {
	
	private $_assetDir = '';
	
	public $selector = '.edit';
	
	public $toolbar = false;
	
	public $plugins = array('load'=>'common/ui, common/format');
	
	
	public function run() {
		$cs = Yii::app()->getClientScript();
		$assets = $this->getAlohaAssetsPath();
		
		$cs->registerScript('aloha', $this->buildAlohaSettings(), CClientScript::POS_HEAD);
		$cs->registerCssFile($assets.'/css/aloha.css');
		$cs->registerScriptFile($assets.'/lib/aloha-full.js', CClientScript::POS_END);
// 		$cs->registerScriptFile($assets.'/lib/require.js', CClientScript::POS_END);
		
		if(! $this->toolbar)
			$cs->registerScript('alohaNoToolbar', "Aloha.ready( function() {setTimeout('Aloha.Sidebar.right.hide();', 10);});", CClientScript::POS_END);
		
		$cs->registerScript('alohaStart', "Aloha.ready( function() {Aloha.jQuery('{$this->selector}').aloha();});", CClientScript::POS_END);
		
	}
	
	
	
	private function buildAlohaSettings()
	{
		$js = <<<EOP
Aloha = window.Aloha || {};
Aloha.settings = Aloha.settings || {};
Aloha.settings.predefinedModules = {
	'jquery': window.jQuery,
	'jqueryui': window.jQuery.ui
};
EOP;
		$js .= "Aloha.settings.baseUrl = '" . $this->getAlohaAssetsPath() . "//'; \n"; 
		$js .= 'Aloha.settings.plugins = ' . json_encode($this->plugins); ";";
		
		return $js;
	}
	
	public function getAlohaAssetsPath()
	{
		if($this->_assetDir === '')
			$this->_assetDir = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'aloha');
		
		return $this->_assetDir;
	}
	
}