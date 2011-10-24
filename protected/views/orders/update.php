<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Создать заказ', 'url'=>array('create')),
	array('label'=>'Просмотреть заказ', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление заказами', 'url'=>array('admin')),
);
?>

<h1>Изменить заказ #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>