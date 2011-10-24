<?php
$this->breadcrumbs = array(
	'Заказы' => array('admin'),
	$model->name,
);

$this->menu = array(
	array('label' => 'Создать заказ', 'url' => array('create')),
	array('label' => 'Изменить заказ', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Удалить заказ', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Управление заказами', 'url' => array('admin')),
);
?>

<h1>Заказ #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php
$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'name',
		array('name' => 'client_id', 'value' => $model->client_name),
		array('name' => 'status', 'value' => Orders::model()->itemAlias("status", $model->status)),
		'date',
		'fixpay',
		'note',
	),
));

$tabs = array
	(
	'works' => array('title' => 'Работы', 'content' => $this->renderPartial('grid-works', array('model' => $model, 'dtprv' => $mdlWorks), true)),
	'contracts' => array('title' => 'Договора', 'content' => $this->renderPartial('grid-contracts', array('model' => $model, 'dtprv' => $mdlContracts), true)),
	'acts' => array('title' => 'Акты', 'content' => $this->renderPartial('grid-acts', array('model' => $model, 'dtprv' => $mdlActs), true)),
	'invoices' => array('title' => 'Счета', 'content' => $this->renderPartial('grid-inv', array('model' => $model, 'dtprv' => $mdlInv), true)),
	'invoicesFkt' => array('title' => 'Счета-фактуры', 'content' => $this->renderPartial('grid-invfkt', array('model' => $model, 'dtprv' => $mdlInvFkt), true)),
	'payments' => array('title' => 'Платежи', 'content' => $this->renderPartial('grid-payments', array('model' => $model, 'dtprv' => $mdlPay), true)),

);
if (Yii::app()->urlManager->showScriptName===true)
	$url=Yii::app()->request->hostInfo.Yii::app()->request->baseUrl.'/index.php';
else
	$url= Yii::app()->request->hostInfo.Yii::app()->request->baseUrl;

$activeTab=str_replace($url, '',Yii::app()->request->urlReferrer);
$activeTab=explode('/', $activeTab);
//echo Yii::app()->request->urlReferrer;
//CVarDumper::dump($activeTab,10,true);die;
if (!key_exists('1', $activeTab)) $activeTab[1]='works';

$this->widget('CTabView', array('tabs' => $tabs,'activeTab'=>$activeTab[1]));
?>
