<?php
$this->breadcrumbs=array(
	'Договора'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Шаблоны договоров', 'url'=>array('contractsTmpl/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contracts-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление договорами</h1>

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
	'id'=>'contracts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'num',
		array('name'=>'client_id','value'=>'$data->client->name','filter'=> CHtml::listData(Clients::model()->findAll(array('order'=>'name')), 'id', 'name')),//
//		'order_id',
		'sum',
		'date',
		'duedate',
//		'autoprolonged',
		array('name'=>'template_id','value'=>'$data->tmpl->name','filter'=> CHtml::listData(ContractsTmpl::model()->findAll(), 'id', 'name')),
		array('name'=>'is_sign','value'=>'Contracts::model()->itemAlias("is_sign",$data->is_sign)'),
//		'body',
		'note',
//		'file',
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
