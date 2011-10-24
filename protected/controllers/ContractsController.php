<?php

class ContractsController extends Controller {
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
		$model = new Contracts;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

		if (isset($_GET['byorder']) and is_numeric($_GET['byorder'])) {
			$order_id = (int) $_GET['byorder'];
			$model->order_id = $order_id;
			$model->order = Orders::model()->findByPk($order_id);
			$model->name = $model->order->name;
			$model->client_id = $model->order->client_id;
			$model->sum = Yii::app()->db->createCommand()
					->select('SUM(cost*quantity) as order_sum')
					->from('{{works}}')
					->where('{{works}}.order_id = '.$order_id)
					->queryScalar();
			$model->num = Yii::app()->db->createCommand()
					->select('max(num*1) as max')
					->from('{{contracts}}')
					->queryScalar();
			$model->num = $model->num + 1;

			if (isset($_POST['Contracts'])) {
//			CVarDumper::dump($_POST['Contracts'],10,true);die;
				$model->attributes = $_POST['Contracts'];
				if ($model->save()) {
					$msg = 'Договор #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' создан';
					Yii::app()->user->setFlash('success', $msg);
					Yii::app()->logger->write($msg);

					if (isset($order_id))
						$this->redirect(array('orders/view', 'id' => $order_id));
					else
						$this->redirect(array('view', 'id' => $model->id));
				}
			}
		}
		$model->date = $model->isNewRecord ? date('Y-m-d') : $model->date;
		$this->render('create', array(
			'model' => $model,
//			'client'=>  Clients::model()->findByAttributes(array('order_id')),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
//		header('Content-type:text/html;charset=UTF-8');
//		$a = new RussianNameProcessor('Лутфуллина Евгения Павловна');      // годится обычная форма
//echo "".$a->fullName($a->gcaseRod);die;
			$model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
		if (isset($_GET['byorder']) and is_numeric($_GET['byorder']))
			$order_id = (int) $_GET['byorder'];

		if (isset($_POST['Contracts'])) {
			$model->attributes = $_POST['Contracts'];
			if ($model->save()) {
				$msg = 'Договор #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' изменён';
				Yii::app()->user->setFlash('success', $msg);
				Yii::app()->logger->write($msg);
				if (isset($order_id))
					$this->redirect(array('orders/view', 'id' => $order_id));
				else
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
				$msg = 'Договор #' . $model->id . ' - ' . $model->name . ' для ' . $model->client->name . ' удалён';
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
//	public function actionIndex() {
//		$dataProvider = new CActiveDataProvider('Contracts');
//		$this->render('index', array(
//			'dataProvider' => $dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new Contracts('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Contracts']))
			$model->attributes = $_GET['Contracts'];

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
		$model = Contracts::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'contracts-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * получить данные о договоре для редактора
	 */
	public function actionChangeBody() {
		if (Yii::app()->request->isAjaxRequest)
		{
//printvar($_POST);
			$return_msg = '';
			$order_id = intval($_POST['order_id']);

			if (!is_array($order_pos = Works::model()->worksByOrder($order_id))) {
				$return_msg .= 'Невозможно получить список работ';
			}
			$data['works'] = "<ul>\n";
			foreach ($order_pos as $o_p) {
				$data['works'] .= '<li>' . $o_p->name . ', ' . $o_p->quantity . $o_p->unit . "</li>\n";
			}
			$data['works'] .= "</ul>\n";
//			echo ($data['works']);die;
			$data['contract']['date'] = $_POST['date'];
			$data['contract']['duedate'] = $_POST['duedate'];
			$data['contract']['name'] = $_POST['name'];
			$data['contract']['num'] = $_POST['num'];
			$data['contract']['sum'] = $_POST['sum'];
//			echo json_encode(CVarDumper::dump($data));die;//Yii::app()->end;
			if (!is_array($data['client'] = Clients::model()->clientByOrder($order_id))) {
				$return_msg .= 'Невозможно получить данные клиента';
			}
//			echo CVarDumper::dump($data['client']);die;
			if (!is_array($data['settings'] = Config::model()->get_settings())) {
				$return_msg .= 'Невозможно получить основные параметры';
			}
//			echo CVarDumper::dump($data['settings']['org.fullname']['value'],10,true);die;
			$body = $this->_tmpl_body($data, Contracts::model()->get_contract_tmpl($_POST['template_id']));
//			echo $body;die;
			if ($body == '')
				$return_msg .= 'Невозможно сформировать шаблон';
			if ($return_msg == '')
				echo ($body);
			else
				echo ($return_msg);
		}
		else {
			echo 'Некорректный формат запроса';
		}
	}

	private function _tmpl_body($data, $tmpl) {

//		Yii::import('application.xyz.XyzClass');
		$numstr = new num2str;
//		$dative_case = new DativeCase;

		if ($data['settings']['org.headfio']['value']) {
			$fio = $data['settings']['org.headfio']['value'];
//			mb_internal_encoding("UTF-8");
//			$a = new RussianNameProcessor($data['settings']['org.headfio']['value']);	  // годится обычная форма
//			$fio = $a->fullName($a->gcaseRod);
//			$fio = explode(' ', $data['settings']['org.headfio']['value']);
//			$fio = $dative_case->convert($fio['0'], $fio['1'], $fio['2']);
		}
		else
			$fio = '____________________';

		if ($data['settings']['org.headpost']['value']) {
			$headpost = $data['settings']['org.headpost']['value'];
//			$a = new RussianNameProcessor($data['settings']['org.headpost']['value']);	  // годится обычная форма
//			$headpost = $a->lastName($a->gcaseRod);
		}
		else $headpost = '____________________';

		$map = array(
			'{name}' => $data['contract']['name'],
			'{sum_num}' => $data['contract']['sum'],
			'{sum}' => $numstr->convert($data['contract']['sum']),
			'{date}' => $data['contract']['date'] ? Yii::app()->dateFormatter->format('d MMMM yyyy', $data['contract']['date']) : ('"___" _________ 20 __ г.'),
			'{num}' => $data['contract']['num'],
			'{duedate}' => $data['contract']['duedate'] ? Yii::app()->dateFormatter->format('d MMMM yyyy', $data['contract']['duedate']) : ('"___" _________ 20 __ г.'),
			'{works}' => $data['works'],
			'{client_name}' => $data['client']['name'] ? ($data['client']['name']) : ('____________________'),
			'{client_fullname}' => ($data['client']['fullname']) ? ($data['client']['fullname']) : ('____________________'),
			'{client_requisite}' => nl2br($data['client']['requisite']),
			'{client_address}' => nl2br($data['client']['address']),
			'{client_contactdata}' => nl2br($data['client']['contactdata']),
			'{client_headpost}' => ($data['client']['headpost']) ? ($data['client']['headpost']) : ('____________________'),
			'{client_headfio}' => ($data['client']['headfio']) ? ($data['client']['headfio']) : ('____________________'),
			'{client_headbasis}' => ($data['client']['headbasis']) ? ($data['client']['headbasis']) : ('____________________'),
			'{org_name}' => ($data['settings']['org.name']['value']) ? ($data['settings']['org.name']['value']) : ('____________________'),
			'{org_fullname}' => ($data['settings']['org.fullname']['value']) ? ($data['settings']['org.fullname']['value']) : ('____________________'),
			'{org_requisite}' => nl2br($data['settings']['org.requisite']['value']),
			'{org_address}' => nl2br($data['settings']['org.address']['value']),
			'{org_contactdata}' => nl2br($data['settings']['org.contactdata']['value']),
			'{org_headpost}' => $headpost,
			'{org_headfio}' => $fio,
			'{org_headbasis}' => ($data['settings']['org.headbasis']['value']) ? ($data['settings']['org.headbasis']['value']) : ('____________________'),
		);
//		$this->load->library('parser');
//		return $this->parser->parse($tmpl->body, $map);
		return strtr(trim($tmpl['body']), $map);
	}

	/**
	 *
	 * @param <type> $contract_id
	 */
	public function actionHtml() {
		if (!isset($_GET['contract_id']) or !is_numeric($_GET['contract_id'])) {
			$msg = 'Неверный ID договора';
			Yii::app()->user->setFlash('error', $msg);
			Yii::app()->logger->write($msg);
		} else {
			$model = Contracts::model()->findByPk($_GET['contract_id']);
			$this->layout = false; //contract/template_pdf';
			$this->render('html', array('model' => $model));
		}
	}

	public function actionPdf($contract_id) {
// create some HTML content
		$contract = $this->mdl_contracts->get_contract($contract_id);

//printvar($html);die;
//
//		//$html = implode('', file('list4.html'));
//		//$html = iconv("ISO-8859-1", "UTF-8", $html);
////require_once("../dompdf_config.inc.php");
//
////if ( get_magic_quotes_gpc() )  $_POST["html"] = stripslashes($_POST["html"]);
////
//		ini_set("memory_limit", "32M");
//		$dompdf = new DOMPDF();
//////  $dompdf->load_html(stripslashes($data['contract_body']));
////$html = implode('', file('application/additive/dompdf/list4.html'));
////$dompdf->load_html($html);
		require_once("application/additive/dompdf-0.5.1/dompdf_config.inc.php"); //-0.5.1
//		$dompdf->load_html($html);
//		$dompdf->set_paper('a4','portrait');
//		$dompdf->render();
//
//		$dompdf->stream("dompdf_out.pdf");
//
////  exit(0);



		$dompdf = new DOMPDF();
//		$dompdf->set_paper(array(0,0,990,1400), 'landscape');
		$dompdf->set_paper('a4', 'portrait');
		$dompdf->load_html($contract->body);

//		$dompdf->selectFont('./fonts/Helvetica.afm',
//		        array('encoding'=>'WinAnsiEncoding'));

		$dompdf->render();
		$dompdf->stream("sample.pdf", array("Attachment" => 0));

///////////////////////////////////////////////////////////////////////
//		// body function
//		require_once('application/additive/tcpdf/config/lang/eng.php');
//		require_once('application/additive/tcpdf/tcpdf.php');
//
//		// create new PDF document
//		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
//
//		// set document information
//		$pdf->SetCreator(PDF_CREATOR);
//		$pdf->SetAuthor("Nicola Asuni");
//		$pdf->SetTitle("TCPDF Example 006");
//		$pdf->SetSubject("TCPDF Tutorial");
//		$pdf->SetKeywords("TCPDF, PDF, example, test, guide");
//
//		// set default header data
//		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//
//		// set header and footer fonts
//		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//		//set margins
//		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//
//		//set auto page breaks
//		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//		//set image scale factor
//		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
//		//set some language-dependent strings
//		$pdf->setLanguageArray($l);
//
//		//initialize document
//		$pdf->AliasNbPages();
//
//		// add a page
//		$pdf->AddPage();
//
//		// ---------------------------------------------------------
//
//		// set font
//		$pdf->SetFont("freesans", "", 8);
//
//
//		// output the HTML content
//		$pdf->writeHTML($data['contract_body'], true, 0, true, 0);
//		// reset pointer to the last page
//		$pdf->lastPage();
//
//		// ---------------------------------------------------------
//
//		//Close and output PDF document
//		$pdf->Output("example_006.pdf", "I", "I");
	}

}
