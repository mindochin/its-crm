<?php
$this->breadcrumbs=array(
	'Acts Tmpls',
);

$this->menu=array(
	array('label'=>'Create ActsTmpl', 'url'=>array('create')),
	array('label'=>'Manage ActsTmpl', 'url'=>array('admin')),
);
?>

<h1>Acts Tmpls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
