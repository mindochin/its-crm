<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Действительно удалить?')),
	array('label'=>'Управлять', 'url'=>array('admin')),
	array('label'=>'[HTML]', 'url'=>array('html','id'=>$model->id)),
	array('label'=>'[PDF]', 'url'=>array('pdf','id'=>$model->id)),
);
?>

<h1>Просмотр счёта #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'client_id',
		'act_id',
		'template_id',
		'date',
		'sum',
		'num',
		'note',
		'is_paid',
		'is_sign',
	),
)); ?>
