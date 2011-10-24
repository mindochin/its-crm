<?php
$this->breadcrumbs=array(
	'Работы'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Управление работами', 'url'=>array('admin')),
);
?>

<h1>Создать работу/услугу</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>