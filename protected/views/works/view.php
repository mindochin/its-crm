<?php
$this->breadcrumbs=array(
	'Works'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Действительно удалить?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Просмотр работы/услуги #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',		
		array('name' => 'client_id', 'value' => $model->client->name),
		array('name' => 'order_id', 'value' => is_null($model->order_id)?$model->order_id:$model->order->name),
		array('name' => 'act_id', 'value' => is_null($model->act_id)?$model->act_id :$model->act->name),
		'name',
		'unit',
		'cost',
		'group',
		'quantity',
		'location',
	),
)); ?>
