<?php
$this->breadcrumbs=array(
	'Клиенты'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Создать клиента', 'url'=>array('create')),
	array('label'=>'Изменить клиента', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить клиента', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление клиентами', 'url'=>array('admin')),
);
?>

<h1>Просмотр клиента #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'fullname',
		'requisite',
		'address',
		'contactdata',
		'headpost',
		'headfio',
		'headbasis',
	),
)); ?>
