<?php
$this->breadcrumbs=array(
	'Invoices Fkts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Шаблоны', 'url'=>array('invoicesFktTmpl/admin')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать счёт-фактуру</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>