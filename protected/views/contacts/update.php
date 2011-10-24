<?php
$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Contacts', 'url'=>array('index')),
	array('label'=>'Create Contacts', 'url'=>array('create')),
	array('label'=>'View Contacts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Contacts', 'url'=>array('admin')),
);
?>

<h1>Update Contacts <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>