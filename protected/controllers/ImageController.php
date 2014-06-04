<?php
class ImageController extends CController {
	public function actions() {
		return array (
				'upload' => array (
						'class' => 'xupload.actions.XUploadAction',
						'path' => Yii::app ()->getBasePath() . "/../images/uploads",
						'publicPath' => Yii::app ()->getBaseUrl () . "/images/uploads",
						'subfolderVar' => "parent_id" 
				) 
		);
	}
}

?>