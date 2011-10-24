<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление счетами', 'url'=>array('admin')),
);
?>

<h1>Создать счет</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>