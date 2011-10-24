<?php
$this->breadcrumbs=array(
	'Contracts',
);

$this->menu=array(
	array('label'=>'Create Contracts', 'url'=>array('create')),
	array('label'=>'Manage Contracts', 'url'=>array('admin')),
);
?>

<h1>Contracts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
