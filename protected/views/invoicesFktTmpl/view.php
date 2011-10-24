<?php
$this->breadcrumbs=array(
	'Acts Tmpls'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Создать шаблон', 'url'=>array('create')),
	array('label'=>'Изменить шаблон', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить шаблон', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Действительно удалить?')),
	array('label'=>'Управление шаблонами актов', 'url'=>array('admin')),
);
?>

<h1>Просмотр шаблона акта #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'body:html',
	),
)); ?>
