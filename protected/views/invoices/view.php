<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Действительно удалить?')),
	array('label'=>'Управлять', 'url'=>array('admin')),
	array('label'=>'[HTML]', 'url'=>array('html','id'=>$model->id)),
	array('label'=>'[PDF]', 'url'=>array('pdf','id'=>$model->id)),
);
?>

<h1>Просмотр счёта #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id','date','num','sum',
		array('name' => 'order_id', 'value' => $model->order->name),
		array('name' => 'client_id', 'value' => $model->client->name),
		array('name' => 'template_id', 'value' => $model->tmpl->name),
		array('name' => 'act_id', 'value' => $model->act->num),
		array('name' => 'is_sign', 'value' => $model->itemAlias("is_sign", $model->is_sign)),	
		array('name' => 'is_paid', 'value' => $model->itemAlias("is_paid", $model->is_paid)),				
		'note',
	),
)); ?>
