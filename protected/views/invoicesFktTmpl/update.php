<?php
$this->breadcrumbs=array(
	'Acts Tmpls'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Создать шаблон', 'url'=>array('create')),
	array('label'=>'Просмотр шаблона', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление шаблонами', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>

<h1>Изменить шаблон счёта-фактуры #<?php echo $model->id; ?></h1>

<?php echo CHtml::link('Переменные для подстановки','#',array('class'=>'search-button')); ?>
<div class="box search-form" style="display:none">
<?php $this->renderPartial('_var',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>