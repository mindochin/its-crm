<?php

class PaymentsController extends Controller {
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
		$model = new Payments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Payments'])) {
			$model->attributes = $_POST['Payments'];
			if ($model->save()) {
				$msg = 'Платёж #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' создан';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
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

		if (isset($_POST['Payments'])) {
			$model->attributes = $_POST['Payments'];
			if ($model->save()) {
				$msg = 'Платёж #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' изменён';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
				$this->redirect(array('view', 'id' => $model->id));
			}
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
				$msg = 'Платёж #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' удалён';
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
		$dataProvider = new CActiveDataProvider('Payments');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Payments('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Payments']))
			$model->attributes = $_GET['Payments'];

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
		$model = Payments::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'payments-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionChangeClient() {
		$return_msg = '';
//		Dumper::d($_POST['order_id']);die;
		if (Yii::app()->request->isAjaxRequest) {
			if (is_numeric($_POST['client_id'])) {
				$q = Orders::model()->open()->listData((int) $_POST['client_id']);
				if (count($q) > 0) {
					foreach ($q as $key => $value) {
						$haOptions[] = array('value' => $key, 'text' => $value);
					}
					$return_msg = json_encode($haOptions);
				}
				else
					$return_msg=json_encode('no');
			} else {
				$return_msg = '[{"value":"",text:"Некорректный формат запроса"}]';
			}
		}
		else {
			$return_msg = '[{"value":"","text":"Некорректный формат запроса"}]';
		}
		echo ($return_msg);
	}
	public function actionChangeOrder() {
		$return_msg = '';
//		Dumper::d($_POST['order_id']);die;
		if (Yii::app()->request->isAjaxRequest) {
			if (is_numeric($_POST['order_id'])) {
				$q = Invoices::model()->listData((int) $_POST['order_id']);
				if (count($q) > 0) {
					foreach ($q as $key => $value) {
						$haOptions[] = array('value' => $key, 'text' => $value);
					}
					$return_msg = json_encode($haOptions);
				}
				else
					$return_msg=json_encode('no');
			} else {
				$return_msg = '[{"value":"","text":"Некорректный формат запроса"}]';
			}
		}
		else {
			$return_msg = '[{"value":"",text:"Некорректный формат запроса"}]';
		}
		echo ($return_msg);
	}

}
