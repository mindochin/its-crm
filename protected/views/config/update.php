<?php
$this->breadcrumbs=array(
	'Параметры'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Просмотр параметра', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление параметрами', 'url'=>array('admin')),
);
?>

<h1>Изменить параметр <?php echo $model->key; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>