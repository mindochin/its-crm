<?php
$this->breadcrumbs=array(
	'Клиенты'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Создать клиента', 'url'=>array('create')),
	array('label'=>'Просмотр клиента', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление клиентами', 'url'=>array('admin')),
);
?>

<h1>Изменить клиента #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>