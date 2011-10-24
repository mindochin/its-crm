<?php
$this->breadcrumbs=array(
	'Клиенты'=>array('index'),
	'Управление',
);

$this->menu=array(

	array('label'=>'Создать клиента', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('clients-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление клиентами</h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<p>
Можно использовать (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>).
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clients-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUpdate'=>false,
	'columns'=>array(
		'id',
		'name',
		'fullname',
		'requisite',
		'address',
		'contactdata',
		/*
		'headpost',
		'headfio',
		'headbasis',
		*/
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
