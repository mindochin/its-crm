<?php
$this->breadcrumbs=array(
	'Works'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Works', 'url'=>array('index')),
	array('label'=>'Create Works', 'url'=>array('create')),
	array('label'=>'Update Works', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Works', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Works', 'url'=>array('admin')),
);
?>

<h1>View Works #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'order_id',
		'act_id',
		'name',
		'unit',
		'cost',
		'group',
		'quantity',
		'location',
	),
)); ?>
