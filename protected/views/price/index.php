<?php
$this->breadcrumbs=array(
	'Prices',
);

$this->menu=array(
	array('label'=>'Create Price', 'url'=>array('create')),
	array('label'=>'Manage Price', 'url'=>array('admin')),
);
?>

<h1>Prices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
