<?php

class MyButtonColumn extends CButtonColumn {

	public function init() {
		$this->viewButtonImageUrl = Yii::app()->request->baseUrl . '/css/img/fsi-icons/zoom.png';
		$this->updateButtonImageUrl = Yii::app()->request->baseUrl . '/css/img/btn/i-edit.png';
		$this->deleteButtonImageUrl = Yii::app()->request->baseUrl . '/css/img/btn/i-cancel.png';
		return parent::init();
	}

}

?>
