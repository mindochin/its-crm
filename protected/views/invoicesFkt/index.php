<?php
$this->breadcrumbs=array(
	'Invoices Fkts',
);

$this->menu=array(
	array('label'=>'Create InvoicesFkt', 'url'=>array('create')),
	array('label'=>'Manage InvoicesFkt', 'url'=>array('admin')),
);
?>

<h1>Invoices Fkts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
