<?php
$this->breadcrumbs=array(
	'Акты'=>array('index'),
	$model->id,
);

$this->menu=array(	
	array('label'=>'Изменить акт', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить акт', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление актами', 'url'=>array('admin')),
	array('label'=>'[HTML]', 'url'=>array('html','id'=>$model->id)),
	array('label'=>'[PDF]', 'url'=>array('pdf','id'=>$model->id)),
);
?>

<h1>Просмотр акта #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,

	'attributes'=>array(
		'id',
		'order_id',
		'client_id',
		'template_id',
		'date',
		'sum',
		'num',
		'note',
		'body:html',
	),
)); ?>
