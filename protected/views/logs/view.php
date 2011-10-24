<?php
$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Logs', 'url'=>array('index')),
	array('label'=>'Create Logs', 'url'=>array('create')),
	array('label'=>'Update Logs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Logs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Logs', 'url'=>array('admin')),
);
?>

<h1>View Logs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'login',
		'class',
		'function',
		'msg',
		'time',
	),
)); ?>
