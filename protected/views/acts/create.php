<?php
$this->breadcrumbs=array(
	'Акты'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Управление актами', 'url'=>array('admin')),
);
?>

<h1>Создать акт для Заказа #<?php echo $model->order_id ?> &mdash; <?php echo $model->order->name ?></h1>

<?php $works = $this->renderPartial('grid-works', array('model' => $model, 'mdlWorks' => Acts::model()->mdlWorks($model->order_id)), true); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'works' =>$works)); ?>