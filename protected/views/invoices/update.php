<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Создать счёт', 'url'=>array('create')),
	array('label'=>'Просмотр счёта', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление счетами', 'url'=>array('admin')),
);
?>

<h1>Изменить счёт #<?php echo $model->id; ?> к заказу <?php echo CHtml::link('#'.$model->order_id,array('orders/view','id'=>$model->order_id)) ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>