<?php

class LogsController extends Controller {

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'rights-write', // perform access control for CRUD operations
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
//	public function write($msg) {
//		$model = new Logs;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if (isset($msg)) {
//			$model->login = Yii::app()->user->name;
//			$model->msg = $msg;
//			$model->save();
//		}
//	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if ($this->loadModel($id)->delete()) {
				$msg = 'Событие ID#' . $id . ' удалено';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Logs('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Logs']))
			$model->attributes = $_GET['Logs'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = Logs::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'logs-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
