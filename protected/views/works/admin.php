<?php
$this->breadcrumbs=array(
	'Работы'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Создать работу', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('works-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление работами/услугами</h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'works-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date',
		array('name'=>'client_id','value'=>'$data->client->name','filter'=> CHtml::listData(Clients::model()->findAll(array('order'=>'name')), 'id', 'name')),
		array('name'=>'order_id','value'=>'$data->order->name','filter'=> CHtml::listData(Orders::model()->findAll(array('order'=>'name')), 'id', 'name')),
		array('name'=>'act_id','value'=>'!is_null($data->act_id)?$data->act->num:null','filter'=> CHtml::listData(Acts::model()->findAll(array('order'=>'num')), 'id', 'num')),
		'name',
		'unit',
		'cost',		
		'quantity',
		'sum',
		/*'group',*/
		'location',
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
