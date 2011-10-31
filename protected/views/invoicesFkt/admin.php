<?php
$this->breadcrumbs=array(
	'Invoices Fkts'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Шаблоны', 'url'=>array('invoicesFktTmpl/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('invoices-fkt-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление счетами-фактурами</h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<p>
Можно использовать (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> или <b>=</b>).
</p>

<?php echo CHtml::link('Продвинутый поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoices-fkt-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'num',
		'order_id',
		'client_id',
		'date',
		'sum',
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
