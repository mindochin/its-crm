<?php

class InvoicesFktController extends Controller {
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
		$model = new InvoicesFkt;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_GET['byorder']) and is_numeric($_GET['byorder']))
			$model->order_id = (int) $_GET['byorder'];

		if (isset($_POST['InvoicesFkt'])) {
			$model->attributes = $_POST['InvoicesFkt'];
			if ($model->save()) {
				$msg = 'Счёт-фактура #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' создан';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);

				if (isset($model->order_id))
					$this->redirect(array('orders/view', 'id' => $model->order_id));
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$model->date = date('Y-m-d');
		$model->num = $model->getLastNum() + 1;

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

		if (isset($_POST['InvoicesFkt'])) {
			$model->attributes = $_POST['InvoicesFkt'];
			if ($model->save()) {
				$msg = 'Счёт-фактура #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' изменён';
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
				$msg = 'Счёт-фактура #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' удалён';
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
		$dataProvider = new CActiveDataProvider('InvoicesFkt');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new InvoicesFkt('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['InvoicesFkt']))
			$model->attributes = $_GET['InvoicesFkt'];

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
		$model = InvoicesFkt::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoices-fkt-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionChangeOrder() {
		$return_msg = '';
//		Dumper::d($_POST['order_id']);die;
		if (Yii::app()->request->isAjaxRequest) {
			if (is_numeric($_POST['order_id'])) {
				$q = Acts::model()->listData($_POST['order_id']);
				if (count($q) > 0) {
					foreach ($q as $key => $value) {
						$haOptions[] = array('optionKey' => $key, 'optionValue' => $value);
					}
					$return_msg = json_encode($haOptions);
				}
				else
					$return_msg='null';
			} else {
				$return_msg = 'Некорректный формат запроса';
			}
		}
		else {
			$return_msg = 'Некорректный формат запроса';
		}
		echo ($return_msg);
	}

	public function actionChangeAct() {
		$return_msg = '';
//		Dumper::d($_POST['order_id']);die;
		if (Yii::app()->request->isAjaxRequest) {
			if (is_numeric($_POST['act_id'])) {
				$q = Acts::model()->findByPk((int) $_POST['act_id'], array('select' => 'sum'));
				if (null !== $q) {
					$return_msg = $q->sum;
				}
				else
					$return_msg='null';
			} else {
				$return_msg = 'Некорректный формат запроса';
			}
		}
		else {
			$return_msg = 'Некорректный формат запроса';
		}
		echo ($return_msg);
	}

	/**
	 *
	 * @param <type> $id
	 */
	public function actionHtml($id) {
		if (!is_numeric($id))
			throw new CHttpException(400, 'Неверный идентификатор счёта.');

		$data['invoice_fkt'] = $this->loadModel($id);
		if (!is_array($works_pos = Works::model()->worksByOrder($data['invoice_fkt']->order_id, $data['invoice_fkt']->act_id))) {
			Yii::app()->user->setFlash('error', 'Список работ для счёта #' . $data['invoice_fkt']->id . ' пуст');
			$this->redirect(array('view', 'id' => $data['invoice_fkt']->id));
		}
		else
			$data['works'] = $works_pos;
		if (is_null($data['client'] = Clients::model()->findByPk($data['invoice_fkt']->client_id))) {
			Yii::app()->user->setFlash('error', 'Данные клиента для счёта #' . $data['invoice_fkt']->id . ' пусты');
			$this->redirect(array('view', 'id' => $data['invoice_fkt']->id));
		}
		if (!is_array($data['settings'] = Config::model()->get_settings())) {
			Yii::app()->user->setFlash('error', 'Основные параметры для счёта #' . $data['invoice_fkt']->id . ' пусты');
			$this->redirect(array('view', 'id' => $data['invoice_fkt']->id));
		}
		$data['body'] = $this->_tmpl_body($data, InvoicesTmpl::model()->findByPk($data['invoice_fkt']->template_id));
		$this->layout = false;
		$this->render('html', array(
			'data' => $data,
		));
	}

	/**
	 *
	 * @param <type> $data
	 * @param <type> $tmpl
	 * @return <type>
	 */
	private function _tmpl_body($data, $tmpl) {
		$numstr = new num2str;
		$map = array(
			//'{name}' => $data['act']->name,
			'inv_sum_num' => $data['invoice_fkt']['sum'],
			'inv_sum' => $numstr->convert($data['invoice_fkt']['sum']),
			'inv_date' => $data['invoice_fkt']['date'] ? (Yii::app()->dateFormatter->format('d MMMM yyyy', $data['invoice_fkt']['date'], TRUE)) : ('"___" _________ 20 __ г.'),
			'inv_num' => $data['invoice_fkt']['num'],
			'works' => $data['works'],
			'works_num' => count($data['works']),
			'client_name' => $data['client']['name'] ? ($data['client']['name']) : ('____________________'),
			'client_fullname' => ($data['client']['fullname']) ? ($data['client']['fullname']) : ('____________________'),
			'client_requisite' => nl2br($data['client']['requisite']),
			'client_address' => nl2br($data['client']['address']),
			'client_contactdata' => nl2br($data['client']['contactdata']),
			'client_headpost' => ($data['client']['headpost']) ? ($data['client']['headpost']) : ('____________________'),
			'client_headfio' => ($data['client']['headfio']) ? ($data['client']['headfio']) : ('____________________'),
			'client_headbasis' => ($data['client']['headbasis']) ? ($data['client']['headbasis']) : ('____________________'),
			'org_name' => ($data['settings']['org.name']->value) ? ($data['settings']['org.name']->value) : ('____________________'),
			'org_fullname' => ($data['settings']['org.fullname']->value) ? ($data['settings']['org.fullname']->value) : ('____________________'),
			'org_requisite' => nl2br($data['settings']['org.requisite']->value),
			'org_address' => nl2br($data['settings']['org.address']->value),
			'org_contactdata' => nl2br($data['settings']['org.contactdata']->value),
			'org_bank' => ($data['settings']['org.name']->value) ? ($data['settings']['org.bank']->value) : ('____________________'),
			'org_inn' => ($data['settings']['org.inn']->value) ? ($data['settings']['org.inn']->value) : ('____________________'),
			'org_kpp' => ($data['settings']['org.kpp']->value) ? ($data['settings']['org.kpp']->value) : ('____________________'),
			'org_bik' => ($data['settings']['org.bik']->value) ? ($data['settings']['org.bik']->value) : ('____________________'),
			'org_sett_acc' => ($data['settings']['org.sett_acc']->value) ? ($data['settings']['org.sett_acc']->value) : ('____________________'),
			'org_correspondent_acc' => ($data['settings']['org.correspondent_acc']->value) ? ($data['settings']['org.correspondent_acc']->value) : ('____________________'),
			'org_vat' => ($data['settings']['org.vat']->value) ? ($data['settings']['org.vat']->value) : ('____________________'),
			'org_vat_value' => ($data['settings']['org.vat_value']->value) ? ($data['settings']['org.vat_value']->value) : ('____________________'),
			'org_glavbuh' => ($data['settings']['org.glavbuh']->value) ? ($data['settings']['org.glavbuh']->value) : ('____________________'),
			'org_headpost' => ($data['settings']['org.headpost']->value) ? ($data['settings']['org.headpost']->value) : ('____________________'),
			'org_headfio' => ($data['settings']['org.headfio']->value) ? ($data['settings']['org.headfio']->value) : ('____________________'),
			'org_headbasis' => ($data['settings']['org.headbasis']->value) ? ($data['settings']['org.headbasis']->value) : ('____________________'),
		);

		$parser = new MyParser();
		return $parser->parse($tmpl->body, $map);
	}
}
