<?php
$this->breadcrumbs=array(
	'Contracts Tmpls'=>array('index'),
	'Create',
);

$this->menu=array(	
	array('label'=>'Управление шаблонами', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>
<h1>Создать шаблон договора</h1>

<?php echo CHtml::link('Переменные для подстановки','#',array('class'=>'search-button')); ?>
<div class="box search-form" style="display:none">
<?php $this->renderPartial('_var',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>