<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="ru" />
		<meta name="generator" content="brain" />
		<meta name="author" content="<?php echo CHtml::encode(Yii::app()->config->get('global.author')) ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/default/base.css" />
		<title><?php echo CHtml::encode(Yii::app()->config->get('global.title')); ?></title>
	</head>

	<body>

		<div class="container" id="page">
			<?php //CVarDumper::dump(Yii::app()->getModule('user')->user()->profile,10,true);die?>
			<div id="header">
				<div class="span-11 a-left"><?php echo CHtml::link(Yii::app()->config->get('global.title'), Yii::app()->urlManager->baseUrl) ?></div>
				<div class="span-13 a-right last"><?php
			if (!Yii::app()->user->isGuest)
				echo 'Приятной работы, о ' . (isset(Yii::app()->getModule('user')->user()->profile->displayname) ? (Yii::app()->getModule('user')->user()->profile->displayname) : (Yii::app()->user->name));
			else
				echo 'Что надобно, гость?'
			?></div>
			</div><!-- header -->
			<div class="clear">&nbsp;</div>

			<?php if (!Yii::app()->user->isGuest): ?>

			<?php //$this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs,));  ?><!-- breadcrumbs -->
			<?php
					$this->widget('zii.widgets.CMenu', array(
						'items' => array(
							array('label' => 'Панель управления', 'url' => array('/dashboard/index'),
								'visible' => Yii::app()->user->checkAccess('dashboard.index'),
								'active' => (Yii::app()->controller->id == 'dashboard' ? true : false),
								),
							array('label' => 'Пользователи', 'url' => array('/user/admin'),
								'visible' => Yii::app()->user->checkAccess('user.admin'),
								'active' => (isset(Yii::app()->controller->module->id)  and Yii::app()->controller->module->id== 'user' ? true : false),
								),
							array('label' => 'Статьи', 'url' => array('/article/admin'),
								'visible' => Yii::app()->user->checkAccess('article.admin'),
								'active' => (Yii::app()->controller->id == 'article' ? true : false),
								),
							array('label' => 'Права доступа', 'url' => array('/rights'),
								'visible' => Yii::app()->user->checkAccess('rights'),
							'active' => (isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id== 'rights' ? true : false),
								),
							array('label' => 'Настройки', 'url' => array('/config/admin'),
								'visible' => Yii::app()->user->checkAccess('config'),
								'active' => (Yii::app()->controller->id == 'config' ? true : false),
								),
							array('label' => Yii::app()->getModule('user')->t("Logout"), 'url' => Yii::app()->getModule('user')->logoutUrl,
								'visible' => !Yii::app()->user->isGuest, 'itemOptions' => array('class' => 'secondary')),
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

			<div id="footer">Copyright &copy; <?php echo date('Y'); ?> by My Company. All Rights Reserved.
				<?php echo Yii::powered(); ?>
								Время: <?= sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) ?> с. Память: <?= round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB" ?>
				<?php $dbStats = Yii::app()->db->getStats();
					echo ' Запросов: ' . $dbStats[0] . ' (за ' . round($dbStats[1], 5) . ' сек)' ?>
			</div><!-- footer -->

		</div><!-- page -->

	</body>
</html>
