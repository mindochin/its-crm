<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-6">
		<div id="sidebar">
			<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title' => 'Звоните!',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array('label' => '89174365448', 'linkOptions' => array('class' => 'large phone')),
					array('label' => '89174128873', 'linkOptions' => array('class' => 'large phone')),
				),
				'htmlOptions' => array('class' => 'menu-v')
			));
			$this->endWidget();

			$this->beginWidget('zii.widgets.CPortlet', array(
				'title' => 'Управление',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array('label' => 'Панель управления', 'url' => array('/dashboard/index'),
						'visible' => Yii::app()->user->checkAccess('dashboard.index'),
						'active' => (Yii::app()->controller->id == 'dashboard' ? true : false),
					),
					array('label' => 'Пользователи', 'url' => array('/user/admin'),
						'visible' => Yii::app()->user->checkAccess('user.admin'),
						'active' => (Yii::app()->controller->id == 'user' ? true : false),
					),
					array('label' => 'Статьи', 'url' => array('/article/admin'),
						'visible' => Yii::app()->user->checkAccess('article.admin'),
						'active' => (Yii::app()->controller->id == 'article' ? true : false),
					),
					array('label' => 'Права доступа', 'url' => array('/rights'),
						'visible' => Yii::app()->user->checkAccess('rights'),
						'active' => (Yii::app()->controller->id == 'rights' ? true : false),
					),
					array('label' => 'Настройки', 'url' => array('/config/admin'),
						'visible' => Yii::app()->user->checkAccess('config'),
						'active' => (Yii::app()->controller->id == 'config' ? true : false),
					),
					array('label' => Yii::app()->getModule('user')->t("Logout"), 'url' => Yii::app()->getModule('user')->logoutUrl,
						'visible' => !Yii::app()->user->isGuest, 'itemOptions' => array('class' => 'secondary')),
				),
				'htmlOptions' => array('class' => 'menu-v'),
			));
			$this->endWidget();
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title' => 'Действия',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items' => $this->menu,
				'htmlOptions' => array('class' => 'menu-v'),
			));
			$this->endWidget();
			?>
		</div><!-- sidebar -->
	</div>
	<div class="span-18 last">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>