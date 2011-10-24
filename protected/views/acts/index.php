<?php
$this->breadcrumbs=array(
	'Acts',
);

$this->menu=array(
	array('label'=>'Create Acts', 'url'=>array('create')),
	array('label'=>'Manage Acts', 'url'=>array('admin')),
);
?>

<h1>Acts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
