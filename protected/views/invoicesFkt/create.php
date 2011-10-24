<?php
$this->breadcrumbs=array(
	'Invoices Fkts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InvoicesFkt', 'url'=>array('index')),
	array('label'=>'Manage InvoicesFkt', 'url'=>array('admin')),
);
?>

<h1>Create InvoicesFkt</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>