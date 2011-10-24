<?php
$this->breadcrumbs=array(
	'Prices'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Price', 'url'=>array('index')),
	array('label'=>'Create Price', 'url'=>array('create')),
	array('label'=>'Update Price', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Price', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Price', 'url'=>array('admin')),
);
?>

<h1>View Price #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'unit',
		'cost',
		'group',
	),
)); ?>
