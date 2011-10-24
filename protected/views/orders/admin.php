<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	'Управление',
);

$this->menu=array(
//	array('label'=>'List Orders', 'url'=>array('index')),
	array('label'=>'Создать Заказ', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('orders-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление Заказами</h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<p>
Можно использовать (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>).
</p>

<?php echo CHtml::link('Продвинутый поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orders-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date',
		'name',
		array('name'=>'client_id','value'=>'$data->client_name','filter'=> CHtml::listData(Clients::model()->findAll(), 'id', 'name')),
		array('name'=>'status','value'=>'Orders::model()->itemAlias("fstatus",$data->status)','filter'=>$model->itemAlias("fstatus")),
		array('name'=>'works_sum','value'=>'$data->works_sum','filter'=>false),
		array('name'=>'invoices_sum','value'=>'$data->invoices_sum','filter'=>false),
//		array('name'=>'invoices_sum','value'=>'Orders::model()->totals($data->id)','filter'=>false),
//		array('name'=>'invoices_sum','value'=>'Invoices::model()->findBySql("SELECT IFNULL((SELECT SUM(sum) FROM ".Yii::app()->db->tablePrefix."invoices WHERE order_id = $data->id),0) as sum")->sum','filter'=>false),//Invoices::sumByOrder($data->id)
		array('name'=>'payments_sum','value'=>'$data->payments_sum','filter'=>false),
//		'fixpay',
		'note',
		array(
			'class'=>'MyButtonColumn',
		),
	),
	'ajaxUpdate'=>false,
//	'afterAjaxUpdate'=>'function(id,err){ alert(err); }',//{ $(".message").text(err); }
)); ?>
