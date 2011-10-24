<?php
$this->breadcrumbs=array(
	'Prices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Price', 'url'=>array('index')),
	array('label'=>'Manage Price', 'url'=>array('admin')),
);
?>

<h1>Create Price</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>