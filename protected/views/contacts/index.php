<?php
$this->breadcrumbs=array(
	'Contacts',
);

$this->menu=array(
	array('label'=>'Create Contacts', 'url'=>array('create')),
	array('label'=>'Manage Contacts', 'url'=>array('admin')),
);
?>

<h1>Contacts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
