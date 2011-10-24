<?php
$this->breadcrumbs=array(
	'Договора'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Изменить договор', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить договор', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление договорами', 'url'=>array('admin')),
	array('label'=>'[HTML]', 'url'=>array('html','contract_id'=>$model->id)),
	array('label'=>'[PDF]', 'url'=>array('pdf','contract_id'=>$model->id)),
);
?>

<h1>Просмотр договора <?php echo $model->name; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'num',
		'sum',
		'date',
		'duedate',
//		'client.name',
		array('name'=>'client_id','value'=>$model->client->name),
		array('name'=>'order_id','type'=>'raw','value'=>CHtml::link('[#'.$model->order_id.'] '.CHtml::encode($model->order->name),array('orders/view','id'=>$model->order_id))),
		array('name'=>'autoprolonged','value'=>$model->itemAlias('autoprolonged',$model->autoprolonged)),
		array('name'=>'template_id','value'=>$model->tmpl->name),
//		array('name'=>'body','value'=>$model->body,'type'=>'raw'),
		'note',
		'file',
	),
)); ?>
