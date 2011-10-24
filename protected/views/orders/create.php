<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Управление заказами', 'url'=>array('admin')),
);
?>

<h1>Создать заказ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>