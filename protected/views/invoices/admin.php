<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Создать счет', 'url'=>array('create')),
	array('label'=>'Шаблоны счетов', 'url'=>array('invoicesTmpl/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('invoices-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление счетами</h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<p>
Можно использовать (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> или <b>=</b>) .
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array('name'=>'order_id','value'=>'$data->order->name','filter'=> Orders::model()->listData()),
		array('name'=>'client_id','value'=>'$data->client->name','filter'=> CHtml::listData(Clients::model()->findAll(array('order'=>'name')), 'id', 'name')),
		array('name'=>'act_id','value'=>'$data->act->num'),//,'filter'=> CHtml::listData(Acts::model()->findAll(), 'id', 'num')),
		'date',
		'sum',
		/*
		'num',
		'note',*/
		array('name'=>'is_paid','value'=>'Invoices::model()->itemAlias("is_paid",$data->is_paid)'),
		array('name'=>'is_sign','value'=>'Invoices::model()->itemAlias("is_sign",$data->is_sign)'),
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
