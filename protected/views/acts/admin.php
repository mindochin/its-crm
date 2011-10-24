<?php
$this->breadcrumbs=array(
	'Акты'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Шаблоны актов', 'url'=>array('actsTmpl/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('acts-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление актами</h1>

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
	'id'=>'acts-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate'=>false,
	'filter'=>$model,
	'columns'=>array(
		'id',
		'num',
		array('name'=>'order_id','value'=>'$data->order->name','filter'=> Orders::model()->listData()),
		array('name'=>'client_id','value'=>'$data->client->name','filter'=> CHtml::listData(Clients::model()->findAll(), 'id', 'name')),
//		array('name'=>'template_id','value'=>'$data->tmpl->name','filter'=> CHtml::listData(ActsTmpl::model()->findAll(), 'id', 'name')),
		'date',
		'sum',		
		array('name'=>'is_sign','value'=>'Acts::model()->itemAlias("is_sign",$data->is_sign)'),
		'note',
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
