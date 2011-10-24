<?php

class ContractsTmplController extends Controller {

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
		$model = new ContractsTmpl;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ContractsTmpl'])) {
			$model->attributes = $_POST['ContractsTmpl'];
			if ($model->save()) {
				$msg = 'Шаблон договора ' . $model->name . ' создан';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
				$this->redirect(array('admin', 'id' => $model->id));
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

		if (isset($_POST['ContractsTmpl'])) {
			$model->attributes = $_POST['ContractsTmpl'];
			if ($model->save()) {
				$msg = 'Шаблон договора ' . $model->name . ' изменён';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
				$this->redirect(array('admin', 'id' => $model->id));
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
			if (null == Contracts::model()->findByAttributes(array('template_id' => (int) $id))) {
				if ($model->delete()) {
					$msg = 'Шаблон договора ' . $model->name . ' удалён';
					Yii::app()->user->setFlash('success', $msg);
					Yii::app()->logger->write($msg);
//				$this->redirect(array('admin', 'id' => $model->id));
				}
			}
			else
				Yii::app()->user->setFlash('notice', 'Удаление невозможно. Шаблон договора ' . $model->name . ' используется!');
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
		$model = new ContractsTmpl('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['ContractsTmpl']))
			$model->attributes = $_GET['ContractsTmpl'];

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
		$model = ContractsTmpl::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'contracts-tmpl-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
