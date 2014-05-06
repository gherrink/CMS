<?php
/**
 * Creates a Site with a DB Content
 * @author Lukas Schreck
 * @copyright 2014
 * @version 0.1
 */

/*
 * @var $DINO
 * @var $ID
*/

?>


<button type="submit" class="btn btn-success" value="addNews"><?php echo MsgPicker::msg()->getMessage(MSG::BTN_NEWS)?></button>
<?php $this->renderPartial('_news',array('head'=>'Testüberschrift','user'=>'Lukas','date'=>'10.11.1992','text'=>'abcd'))?>




