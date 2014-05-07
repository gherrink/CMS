<?php
/**
 * Creates a Site with a DB Content
 * @author Lukas Schreck
 * @copyright 2014
 * @version 0.1
 */
?>

<br>
<br>
<?php
$this->beginWidget('bootstrap.widgets.BsPanel');
?>
<div class="row">
	<div class="col-sm-9"><h2>Überschrift</h2></div>
 	<div class="col-sm-3"><h4>
 		<?php
 		$a = '06.05.2014 / ';
 		$b = Yii::app()->user->getID();
 		$c = $a.$b;
		echo BsHtml::well($c, array('size' => BsHtml::WELL_SIZE_SMALL));
		?>
		</h4></div>
</div>

<div class="edit">
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
</div>


<?php
$this->endWidget();
?>

<br>
<br>





