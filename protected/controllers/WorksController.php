<?php

class WorksController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Works;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_GET['byorder']) and is_numeric($_GET['byorder'])) {
			$model->order_id = (int) $_GET['byorder'];
			$model->client_id = $model->order->client_id;
		}

		if (isset($_POST['Works'])) {			
			$model->attributes = $_POST['Works'];
			if ($model->save()) {
//				Dumper::d($model->attributes);die;
				$msg = 'Услуга #' . $model->id . ' - ' . $model->name . ' создана';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
				if (isset($model->order_id))
					$this->redirect(array('orders/view', 'id' => $model->order_id));
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_GET['byorder']) and is_numeric($_GET['byorder']))
			$order_id = (int) $_GET['byorder'];

		if (isset($_POST['Works'])) {
			$model->attributes = $_POST['Works'];
			if ($model->save()) {
				$msg = 'Услуга #' . $model->id . ' - ' . $model->name . ' изменена';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
				if (isset($order_id))
					$this->redirect(array('orders/view', 'id' => $order_id));
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
			else
				Yii::app()->user->setFlash('error', 'Позиция НЕ обновлена');
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			if ($model->delete()) {
				$msg = 'Услуга #' . $model->id . ' - ' . $model->name . ' удалена';
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
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Works');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Works('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Works']))
			$model->attributes = $_GET['Works'];

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
		$model = Works::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'works-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	function actionRecalc() {
		$all=Works::model()->findAll('client_id=0');
		foreach ($all as $key => $value) {
			Dumper::d($value);
			$model=$this->loadModel($value->id);
			if (!isset ($model->client_id) and $model->client_id==='0') {
				echo $model->id.' '.$model->order->client->name;
				echo '<br>';
				$model->client_id=$model->order->client->id;
				$model->save();				
			}
			else {
			echo '----'.$model->id.' '.$model->order->client->name;
			echo '<br>';}
		}
	}

}
