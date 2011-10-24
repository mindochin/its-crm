<?php
$this->breadcrumbs=array(
	'Invoices Fkts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InvoicesFkt', 'url'=>array('index')),
	array('label'=>'Create InvoicesFkt', 'url'=>array('create')),
	array('label'=>'Update InvoicesFkt', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InvoicesFkt', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InvoicesFkt', 'url'=>array('admin')),
);
?>

<h1>View InvoicesFkt #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'client_id',
		'date',
		'amount',
		'num',
		'note',
	),
)); ?>
