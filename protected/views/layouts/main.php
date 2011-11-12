<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, max-age=0, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="Fri, 01 Jan 1990 00:00:00 GMT"/>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/<?php echo Yii::app()->config->get('global.style') ?>/print.css" media="print" />
		<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/' . Yii::app()->config->get('global.style') . '/base.css'); ?>
		<title>Веб-система ITS-CRM v0.1.1 - <?php echo CHtml::encode(Yii::app()->config->get('org.name')); ?></title>
	</head>

	<body>

		<div class="container">
			<div id="header">
				<div class="span-8 a-left strong">Веб-система ITS-CRM v0.1.1</div>
				<div class="span-8 a-center"><? echo CHtml::link(Yii::app()->config->get('org.name'), Yii::app()->request->baseUrl) ?></div>
				<div class="span-8 last a-right"><?php
		if (!Yii::app()->user->isGuest)
			echo 'Приятной работы, ' .
//			(isset(Yii::app()->getModule('user')->user()->profile->displayname) ? (Yii::app()->getModule('user')->user()->profile->displayname) : (Yii::app()->user->name)) . ' ' .
			Yii::app()->user->name . ' ' . CHtml::link('[' . Yii::app()->getModule('user')->t("Logout") . ']', Yii::app()->getModule('user')->logoutUrl);
		else
			echo 'Что надобно, гость? ' . CHtml::link('[' . Yii::app()->getModule('user')->t("Login") . ']', Yii::app()->getModule('user')->loginUrl);
		?></div>
			</div>
			<div class="clear">&nbsp;</div>

			<?php if (!Yii::app()->user->isGuest): ?>

			<?php //$this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs,));  ?><!-- breadcrumbs -->
			<?php
				$this->widget('zii.widgets.CMenu', array(
					'items' => array(
						array('label' => 'Заказы', 'url' => array('/orders/admin'),
							'visible' => Yii::app()->user->checkAccess('orders.admin'),
							'active' => (Yii::app()->controller->id == 'orders' ? true : false),
						),
						array('label' => 'Клиенты', 'url' => array('/clients/admin'),
							'visible' => Yii::app()->user->checkAccess('clients.admin'),
							'active' => (Yii::app()->controller->id == 'clients' ? true : false),
						),
						array('label' => 'Договора', 'url' => array('/contracts/admin'),
							'visible' => Yii::app()->user->checkAccess('contracts.admin'),
							'active' => (Yii::app()->controller->id == 'contracts' or Yii::app()->controller->id == 'contractsTmpl' ? true : false),
						),
						array('label' => 'Акты', 'url' => array('/acts/admin'),
							'visible' => Yii::app()->user->checkAccess('acts.admin'),
							'active' => (Yii::app()->controller->id == 'acts' or Yii::app()->controller->id == 'actsTmpl' ? true : false),
						),
						array('label' => 'Счета', 'url' => array('/invoices/admin'),
							'visible' => Yii::app()->user->checkAccess('invoices.admin'),
							'active' => (Yii::app()->controller->id == 'invoices' or Yii::app()->controller->id == 'invoicesTmpl' ? true : false),
						),
						array('label' => 'Счета-фактуры', 'url' => array('/invoicesFkt/admin'),
							'visible' => Yii::app()->user->checkAccess('invoicesFkt.admin'),
							'active' => (Yii::app()->controller->id == 'invoicesFkt' or Yii::app()->controller->id == 'invoicesFktTmpl' ? true : false),
						),
						array('label' => 'Работы', 'url' => array('/works/admin'),
							'visible' => Yii::app()->user->checkAccess('works.admin'),
							'active' => (Yii::app()->controller->id == 'works' ? true : false),
						),
						array('label' => 'Прайс', 'url' => array('/price/admin'),
							'visible' => Yii::app()->user->checkAccess('price.admin'),
							'active' => (Yii::app()->controller->id == 'price' ? true : false),
						),
						array('label' => 'Платежи', 'url' => array('/payments/admin'),
							'visible' => Yii::app()->user->checkAccess('payments.admin'),
							'active' => (Yii::app()->controller->id == 'payments' ? true : false),
						),
						array('label' => 'Контакты', 'url' => array('/contacts/admin'),
							'visible' => Yii::app()->user->checkAccess('contacts.admin'),
							'active' => (Yii::app()->controller->id == 'contacts' ? true : false),
						),
						array('label' => 'Настройки', 'url' => '', 'items' => array(
								array('label' => 'Пользователи', 'url' => array('/user/admin'),
									'visible' => Yii::app()->user->checkAccess('user.admin'),
									'active' => (isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id == 'user' ? true : false),
								),
								array('label' => 'Права доступа', 'url' => array('/rights'),
									'visible' => Yii::app()->user->checkAccess('rights'),
									'active' => (isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id == 'rights' ? true : false),
								),
								array('label' => 'Журнал событий', 'url' => array('/logs/admin'),
									'visible' => Yii::app()->user->checkAccess('logs.admin'),
									'active' => (Yii::app()->controller->id == 'logs' ? true : false),
								),
								array('label' => 'Параметры', 'url' => array('/config/admin'),
									'visible' => Yii::app()->user->checkAccess('config'),
									'active' => (Yii::app()->controller->id == 'config' ? true : false),
								),
							),
							'visible' => Yii::app()->user->checkAccess('rights'),
//							'active' => (Yii::app()->controller->id == 'config' ? true : false),
						)
					),
					'htmlOptions' => array('class' => 'nav'),
				));
				$this->widget('zii.widgets.CMenu', array(
					'items' => $this->menu,
					'htmlOptions' => array('class' => 'nav second'),
				));
			?>

<?php endif; ?>

<?php echo $content; ?>

				<div id="footer">Время: <?= sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) ?> с. Память: <?= round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB" ?>
<?php $dbStats = Yii::app()->db->getStats();
				echo ' Запросов: ' . $dbStats[0] . ' (за ' . round($dbStats[1], 5) . ' сек)' ?>
			</div><!-- footer -->
		</div><!-- page -->
	</body>
</html>
