<?php
$this->breadcrumbs=array(
	'Параметры'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Изменить параметр', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Config', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление параметрами', 'url'=>array('admin')),
);
?>

<h1>Просмотр параметра #<?php echo $model->key; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'key',
		'value',
		'desc',
	),
)); ?>
