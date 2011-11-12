<?php
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление платежами', 'url'=>array('admin')),
);
?>

<h1>Создать платёж</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>