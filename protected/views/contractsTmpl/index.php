<?php
$this->breadcrumbs=array(
	'Contracts Tmpls',
);

$this->menu=array(
	array('label'=>'Create ContractsTmpl', 'url'=>array('create')),
	array('label'=>'Manage ContractsTmpl', 'url'=>array('admin')),
);
?>

<h1>Contracts Tmpls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
