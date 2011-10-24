<?php
$this->breadcrumbs=array(
	'Invoices Fkts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InvoicesFkt', 'url'=>array('index')),
	array('label'=>'Create InvoicesFkt', 'url'=>array('create')),
	array('label'=>'View InvoicesFkt', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InvoicesFkt', 'url'=>array('admin')),
);
?>

<h1>Update InvoicesFkt <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>