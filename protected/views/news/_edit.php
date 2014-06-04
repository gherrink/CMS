<?php
/**
 * @author Lukas Schreck
 * @copyright 2014
 * @version 0.1
 * Popup-Fenster für die Neuigkeitenerstellung
 */
/* 
 * @var ContentController $this 
 * @var Content $model
 * @var BsActiveForm $form
 * @var String $url
 */
$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
		'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
		'enableAjaxValidation' => false,
		'id' => 'site-form',
		'htmlOptions' => array(
				'onsubmit' => "return false;",
				'onkeypress' => " if(event.keyCode == 13){ cmsSubmitForm('modal', 'site-form', '" . $url . "'); } ",
		),
));

?>

<p>Nachricht wird im Namen von <?php echo Yii::app()->user->getID() ?> geposted</p>
<input type="text" class="form-control" placeholder="Text einfügen">

<div class="row">
<div class="col-sm-6">
        <?php
        echo $form->dropDownListControlGroup($model, 'roleaccess', $roles, array(
            'options' => array($selectedRole => array('selected' => true)),
            'labelOptions' => array('class' => 'control-label required'),
            'controlOptions' => array('class' => ''),
        ));
        ?>
    </div>
</div>
<?php
$this->endWidget();