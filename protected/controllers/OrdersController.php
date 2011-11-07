<?php

class OrdersController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout = '//layouts/column2';

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
			'mdlContracts' => Orders::model()->mdlContracts($id),
			'mdlActs' => Orders::model()->mdlActs($id),
			'mdlInvFkt' => Orders::model()->mdlInvFkt($id),
			'mdlPay' => Orders::model()->mdlPay($id),
			'mdlInv' => Orders::model()->mdlInv($id),
			'mdlWorks' => Orders::model()->mdlWorks($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Orders;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Orders'])) {
			$model->attributes = $_POST['Orders'];
			if ($model->save()) {
				$msg = 'Заказ #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' создан';
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

		if (isset($_POST['Orders'])) {
			$model->attributes = $_POST['Orders'];
			if ($model->save()) {
				$msg = 'Заказ #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' изменён';
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

			$model=$this->loadModel($id);
			if (Payments::model()->count('order_id=' . $id) !== 0) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					Contracts::model()->deleteAll('order_id=' . $id);
					Acts::model()->deleteAll('order_id=' . $id);
					Invoices::model()->deleteAll('order_id=' . $id);
					InvoicesFkt::model()->deleteAll('order_id=' . $id);
					Works::model()->deleteAll('order_id=' . $id);

					$msg = 'Заказ #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' и документы по нему удалёны';

					$model->delete();

//					$transaction->commit();
					
					Yii::app()->user->setFlash('success', $msg);
					Yii::app()->logger->write($msg);
				} catch (Exception $e) {
					$transaction->rollBack();
					$msg = 'Заказ #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' - удаление не удалось';
					Yii::app()->user->setFlash('error', $msg);
					Yii::app()->logger->write($msg);
				}
			} else {
				$msg = 'Заказ #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' - удаление невозможно. По этому заказу уже были проведены платежи';
				Yii::app()->user->setFlash('notice', $msg);
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
		$model = new Orders('search');
		$model->unsetAttributes();  // clear any default values
		$model->status='open';
		if (isset($_GET['Orders']))
			$model->attributes = $_GET['Orders'];

//		$dtPrvdr = $model->search();
//		$dtPrvdr->criteria->with = array('client');

		$this->render('admin', array(
			'model' => $model,
//			'dtprv'=>$dtPrvdr,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = Orders::model()->findByPk((int) $id, Orders::model()->getSearchCriteria());
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
