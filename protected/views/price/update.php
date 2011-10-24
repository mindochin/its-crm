<?php
$this->breadcrumbs=array(
	'Prices'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Price', 'url'=>array('index')),
	array('label'=>'Create Price', 'url'=>array('create')),
	array('label'=>'View Price', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Price', 'url'=>array('admin')),
);
?>

<h1>Update Price <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>