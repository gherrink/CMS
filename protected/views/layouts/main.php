<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?php echo Yii::app()->language ?>" />
	<script src="/cms/css/cms.js" type="text/javascript"></script>
	<?php
		$cs			= Yii::app()->clientScript;
		$path		= Yii::app()->baseUrl;
		$themePath	= Yii::app()->theme->baseUrl;
	
		/**
		 * StyleSHeets
		 */
		$cs->registerCssFile($path . '/css/bootstrap/css/bootstrap.min.css');
		$cs->registerCssFile($themePath . '/css/bootstrap-theme.css');
		$cs->registerCssFile($path . '/css/cms.css');
	
		/**
		 * JavaScripts
		 */
		$cs->registerCoreScript('jquery', CClientScript::POS_END);
		$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
		$cs->registerScriptFile($path . '/css/bootstrap/js/bootstrap.min.js', CClientScript::POS_END);
		$cs->registerScript('tooltip', "$('[data-toggle=\"tooltip\"]').tooltip();$('[data-toggle=\"popover\"]').tooltip()", CClientScript::POS_READY);
// 		$cs->registerScriptFile($path . '/css/cms.js');
	?>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
    	<script src="<?php
			echo Yii::app()->baseUrl . '/css/bootstrap/js/html5shiv.js';
		?>"></script>
    	<script src="<?php
			echo Yii::app()->baseUrl . '/css/bootstrap/js/respond.min.js';
		?>"></script>
	<![endif]-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="mainmenu">
		<?php $this->widget('application.widgets.menu.NLevelNav', Menu::getMenuArray()); ?>
	</div><!-- mainmenu -->
	<?php 
		if(isset($this->breadcrumbs))
		{
			$this->widget('bootstrap.widgets.BsBreadcrumb', array(
				'links' => $this->breadcrumbs,
				'tagName' => 'ul',
				'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
				'inactiveLinkTemplate' => '<li>{label}</li>',
				'homeLink' => '<li><a href="'.Yii::app()->homeUrl.'">'. BsHtml::icon(BsHtml::GLYPHICON_HOME) .'</a></li>',
			));
		}
	?>
	
	<?php 
		if($this->hasMessages())
		{
			foreach ($this->getMessages() as $msg)
				echo BsHtml::alert($msg->getStatus(), $msg->getHead().' '.$msg->getMessage());
		}
	?>

	<?php echo $content; ?>

	<div class="clear"></div>
	
	<hr>
	<div id="footer" class="text-center">
		<?php echo MsgPicker::msg()->getMessage(MSG::FOOTER, array('year'=>date('Y')))?>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<?php
$this->widget('bootstrap.widgets.BsModal', array(
	'id' => 'modal',
	'header' => 'Modal Heading',
	'content' => '<p>Modal body</p>',
	'footer' => array(
		BsHtml::button('OK', array(
			'data-dismiss' => 'modal',
		))
	),
	'htmlOptions' => array(
		'data-keyboard' => 'false',
		'data-backdrop' => 'static',
	),
	'closeText' => false,
));

$this->widget('bootstrap.widgets.BsModal', array(
	'id' => 'modalmsg',
	'header' => 'Modal Heading',
	'content' => '<p>Modal body</p>',
	'footer' => array(
		BsHtml::button('OK', array(
			'data-dismiss' => 'modalmsg',
		))
	),
));
?><!-- modal -->



</body>
</html>
