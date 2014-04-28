<?php
class NewsController extends Controller{
	
	public $defaultAction = 'news';
	
	public function actionNews(){
		$this->render('news', array('DINO'=>'Hallo hier ist Psaiko Dino'));
					
	}
	
}