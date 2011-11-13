<?php
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Просмотр платежа #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		array('name' => 'client_id', 'value' => $model->client->name),
		array('name' => 'order_id', 'value' => is_null($model->order_id)?$model->order_id:$model->order->name),		
		array('name' => 'invoice_id', 'value' => is_null($model->invoice_id)?$model->invoice_id:$model->invoice->name),		
		'sum',
		'note',
	),
)); ?>
