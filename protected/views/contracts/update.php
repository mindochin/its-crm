<?php
$this->breadcrumbs=array(
	'Contracts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Управление договорами', 'url'=>array('admin')),
	array('label'=>'Просмотр', 'url'=>array('view')),
);
?>

<h1>Изменить договор #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>