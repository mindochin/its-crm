<?php

class SiteController extends Controller {

	public $defaultAction = 'contact';

	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	public function filters() {
		return array(
			'rights-error,contact'//accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
//		$this->layout = '//layouts/column2';
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact() {
		$model = new ContactForm;
		if (isset($_POST['ContactForm'])) {
			$model->attributes = $_POST['ContactForm'];
			if ($model->validate()) {
				$criteria = new CDbCriteria(array(
							'condition' => 'superuser=1',
							'condition' => 'notify=1',
							'with' => 'profile',
						));
				$users = User::model()->findAll($criteria);
				foreach ($users as $email) {
					$headers = "From: $model->name <{$model->email}>\r\nReply-To: {$model->email}";
					mail($email->email, 'Запрос со страницы контактов', $model->body, $headers);
					Yii::app()->user->setFlash('contact', 'Спасибо за Ваше сообщение. Мы ответим как можно скорее.');
				}
				$this->refresh();
			}
		}
		$content = Article::model()->findByAttributes(array('url' => 'contact'));

		$this->render('contact', array('model' => $model, 'content' => $content));
	}

}