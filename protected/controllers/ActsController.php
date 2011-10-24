<?php

class ActsController extends Controller {
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
		$model = new Acts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_GET['byorder']) and is_numeric($_GET['byorder'])) {
			$model->order_id = (int) $_GET['byorder'];

			if (isset($_POST['Acts'])) {
				$model->attributes = $_POST['Acts'];
				if ($model->save()) {
					$works_num=0;
					if (key_exists('Works',$_POST)) $works_num=$model->setWorks($_POST['Works']);
//					$c = Works::model()->updateByPk($_POST['Works'], array('act_id' => (int) $model->id), array('condition' => 'order_id=' . (int) $model->order_id));
					$msg = 'Акт #' . $model->id . ' для Заказа #' . $model->order_id . ' &mdash; ' . $model->order->name . ' создан. Работ/услуг по акту: ' . $works_num;
					Yii::app()->user->setFlash('success', $msg);
					Yii::app()->logger->write($msg);

					if (isset($model->order_id))
						$this->redirect(array('orders/view', 'id' => $model->order_id));
					else
						$this->redirect(array('view', 'id' => $model->id));
				}
			}
			$model->date = date('Y-m-d');
			$model->client_id = $model->order->client->id;
			$model->num = $model->getLastNum() + 1;
			$this->render('create', array(
				'model' => $model,
//				'mdlWorks' => Acts::model()->mdlWorks($model->order_id),
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
//		Dumper::d($_POST);die;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Acts'])) {
			$model->attributes = $_POST['Acts'];
			if ($model->save()) {
				$works_num=0;
				if (key_exists('Works',$_POST)) $works_num=$model->setWorks($_POST['Works']);
				$msg = 'Акт #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' изменён. Работ/услуг по акту: '.$works_num;
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
			if (count(Invoices::model()->findAllByAttributes(array('act_id' => (int) $id))) == 0) {
				if ($model->delete()) {
					$msg = 'Акт #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' удалён';
					Yii::app()->user->setFlash('success', $msg);
					Yii::app()->logger->write($msg);
				}
			} else {
				$msg = 'Акт #' . $model->id . ' для Заказа #' . $model->order_id . ' ' . $model->order->name . ' нельзя удалить - есть счета';
				Yii::app()->user->setFlash('notice', $msg);
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
		$dataProvider = new CActiveDataProvider('Acts');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Acts('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Acts']))
			$model->attributes = $_GET['Acts'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionHtml($id) {
		$model = $this->loadModel($id);
		$this->layout = false; //contract/template_pdf';
		$this->render('html', array('model' => $model));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = Acts::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'acts-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * получить данные о акте для редактора
	 */
	public function actionChangeBody() {
		if (Yii::app()->request->isAjaxRequest) {
			$return_msg = '';

			if (!isset($_POST['act_id']) and !isset($_POST['order_id']) and empty($_POST['works']) and !isset($_POST['client_id']) and !isset($_POST['template_id'])
					and !isset($_POST['date']) and !isset($_POST['sum']) and !isset($_POST['num']))
				die("Необходимых данных недостаточно </br>");

			$data['act']['date'] = $_POST['date'];
			$data['act']['sum'] = $_POST['sum'];
			$data['act']['num'] = (int) $_POST['num'];

			if (!is_array($order_pos = Works::model()->worksByOrder($_POST['order_id'], $_POST['act_id'], $_POST['works'])))
				$return_msg .= "Невозможно получить список работ </br>";
			$data['works'] = $order_pos;
//			parse_str($_POST['works']);
//			Dumper::d($Works);die;
			$data['contract'] = Contracts::model()->findByPk((int) $_POST['order_id'], array('select' => 'date, num'));
//			if (is_null($data['contract'] = Contracts::model()->findByPk((int) $_POST['order_id'], array('select' => 'date, num')))) {
//				$return_msg .= "Невозможно получить данные договора \n";
//			}

			if (is_null($data['client'] = Clients::model()->findByPk((int) $_POST['client_id']))) {
				$return_msg .= "Невозможно получить данные клиента \n";
			}

			if (!is_array($data['settings'] = Config::model()->get_settings())) {
				$return_msg .= "Невозможно получить основные параметры \n";
			}

			$body = $this->_tmpl_body($data, Acts::model()->get_act_tmpl($_POST['template_id']));
			if ($body == '')
				$return_msg .= "Невозможно сформировать шаблон \n";

			if ($return_msg == '')
				echo ($body);
			else
				echo ($return_msg);
		}
		else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	private function _tmpl_body($data, $tmpl) {//printvar($data);
		$numstr = new num2str;
		$map = array(
			//'{name}' => $data['act']->name,
			'act_sum_num' => $data['act']['sum'],
			'act_sum' => $numstr->convert($data['act']['sum']),
			'act_date' => $data['act']['date'] ? (Yii::app()->dateFormatter->format('d MMMM yyyy', $data['act']['date'], TRUE)) : ('"___" _________ 20 __ г.'),
			'act_num' => $data['act']['num'],
			'works' => $data['works'],
			'contract_date' => $data['contract']['date'] ? (Yii::app()->dateFormatter->format('d MMMM yyyy', $data['contract']->date, TRUE)) : ('"___" _________ 20 __ г.'),
			'contract_num' => $data['contract']['num'] ? ($data['contract']->num) : ('___'),
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
			'org_headpost' => ($data['settings']['org.headpost']->value) ? ($data['settings']['org.headpost']->value) : ('____________________'),
			'org_headfio' => ($data['settings']['org.headfio']->value) ? ($data['settings']['org.headfio']->value) : ('____________________'),
			'org_headbasis' => ($data['settings']['org.headbasis']->value) ? ($data['settings']['org.headbasis']->value) : ('____________________'),
		);

		$parser = new MyParser();
		return $parser->parse($tmpl->body, $map);
	}
	/**
	 *
	 */
//	function actionEditWork() {
//		$return_msg = 'Ответ: ';
//		if (Yii::app()->request->isAjaxRequest) {
//			if (isset($_POST['work_id']) and isset($_POST['act_id'])) {
//				$work_id = (int) $_POST['work_id'];
//				$act_id = (int) $_POST['act_id'];
//				if (!is_null($mdlWorks = Works::model()->findByPk($work_id))) {
//
//					if ($ab->updateByPk($ab_id, array('ab_enter' => null), "ab_enter='$sp_id'") == 1) {
//						SpecAbit::model()->updateAll(array('s2a_competition' => 's2a_priority'), 's2a_ab_id = :abid', array(':abid' => $ab_id));
//						$return_msg .= 'Абитуриент #' . $ab->ab_id . ' ' . $ab->ab_surname . ' ' . $ab->ab_name . ' ' . $ab->ab_patronym . ' покинул специальность #' . $sp_id . ' ' . $sp->sp_name;
//						Yii::app()->logger->write($return_msg);
//					} else
//						$return_msg .= 'Абитуриент не смог покинуть специальность';
//				}
//				else
//					$return_msg .= 'Работа/услуга не найдена!';
//			}
//			else
//				$return_msg .= 'Нужен ID акта или работы';
//		}
//		else
//			$return_msg .= 'Некорректный формат запроса';
//
//		echo json_encode($return_msg);
//		Yii::app()->end();
//	}
}
