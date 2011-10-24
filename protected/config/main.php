<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
//	'name'=>'My Web Application',
	'defaultController' => 'orders',
	'language' => 'ru',
	// preloading 'log' component
	'preload' => array('log'),
	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',
	),
	'modules' => array(
// uncomment the following to enable the Gii tool

		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => 'q',
			'ipFilters' => array('*'),
		),
		'rights' => array(
			'superuserName' => 'Admin',
			'authenticatedName' => 'Authenticated',
			'userIdColumn' => 'id',
			'userNameColumn' => 'username',
			'enableBizRule' => true,
			'enableBizRuleData' => false,
			'displayDescription' => true,
			'flashSuccessKey' => 'RightsSuccess',
			'flashErrorKey' => 'RightsError',
			'layout' => 'rights.views.layouts.main',
			'appLayout' => 'application.views.layouts.main',
//			'cssFile' => 'rights.css',
//			'install' => true,
			'debug' => false,
		),
		'user' => array(
			'tableUsers' => '{{u_users}}',
			'tableProfiles' => '{{u_profiles}}',
			'tableProfileFields' => '{{u_profiles_fields}}',			
			'returnUrl' => array('/orders/admin'),
		),
	),
	// application components
	'components' => array(
		'user' => array(
// enable cookie-based authentication
			'allowAutoLogin' => true,
			'class' => 'RWebUser',
			'loginUrl' => array('/user/login'),
		),
		'widgetFactory' => array(
			'widgets' => array(
				'CListView' => array(
					'pager' => array('class' => 'MyFloatPager'),
					'template' => "{items}\n{summary}\n{pager}",
					'cssFile' => false,
//					'showTableOnEmpty'=>false,
				),
				'CGridView' => array(
					'pager' => array('class' => 'MyFloatPager'),
					'template' => "{items}\n{summary}\n{pager}",
//					'showTableOnEmpty'=>false,
				),
			),
		),
		'authManager' => array(
			'class' => 'RDbAuthManager',
			'connectionID' => 'db',
			'defaultRoles' => array('Guest'),
		),
		// uncomment the following to enable URLs in path-format

		'urlManager' => array(
			'urlFormat' => 'path',
			'rules' => array(
//				'' => 'article/page/url/about',
//				'page/<url:\w+>' => 'article/page',
//				'comment/feed/<owner:\w+>/<owner_id:\d+>/*' => 'comment/feed',
//				'<controller:\w+>/<action:\w+>/*' => '<controller>/<action>',
			),
		),
		/*
		  'db'=>array(
		  'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		  )
		  ,
		 */
//		'cache' => array(
//			'class' => 'CFileCache',
//		),
		// uncomment the following to use a MySQL database
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=its-crm-new',
			'emulatePrepare' => true,
			'username' => 'vlad',
			'password' => 'q3dmm6',
			'charset' => 'utf8',
			'tablePrefix' => 'itscrm_',
			'enableParamLogging' => true,
			'enableProfiling' => true,
			'schemaCachingDuration' => 3600
		),
		'errorHandler' => array(
// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
//				array(
//					'class' => 'CFileLogRoute',
//					'levels' => 'error, warning',
//				),
//			// uncomment the following to show log messages on web pages
//				array(
//					'class' => 'CWebLogRoute',
//					'categories' => 'system.db.*',
//				),
			),
		),
		'config' => array(
			'class' => 'application.components.MyConfig',
			'strictMode' => true,
			'configTableName' => '{{config}}'
		),
		'logger'=>array('class'=>'application.components.MyLogger')
	),
	// application-level parameters that can be accessed
// using Yii::app()->params['paramName']
	'params' => array(
// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
	),
);
