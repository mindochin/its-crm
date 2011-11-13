<?php
$this->breadcrumbs=array(
	'Invoices Fkts'=>array('index'),
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

<h1>Просмотр счёта-фактуры #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'num',
		array('name' => 'order_id', 'value' => $model->order->name),
		array('name' => 'client_id', 'value' => $model->client->name),
		array('name' => 'template_id', 'value' => $model->tmpl->name),
		array('name' => 'act_id', 'value' => $model->act->num),
		array('name' => 'is_sign', 'value' => $model->itemAlias("is_sign", $model->is_sign)),	
		'date',
		'sum',
		'cargo_send',
		'cargo_send_info',
		'cargo_addr',
		'cargo_addr_info',
		'body',
	),
)); ?>
