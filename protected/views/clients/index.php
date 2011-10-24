<?php
$this->breadcrumbs=array(
	'Clients',
);

$this->menu=array(
	array('label'=>'Create Clients', 'url'=>array('create')),
	array('label'=>'Manage Clients', 'url'=>array('admin')),
);
?>

<h1>Clients</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
