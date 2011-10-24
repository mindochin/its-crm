<?php
$this->breadcrumbs=array(
	'Акты'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Просмотреть акт', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление актами', 'url'=>array('admin')),
);
?>

<h1>Изменить акт для Заказа #<?php echo $model->order_id ?> &mdash; <?php echo $model->order->name ?></h1>

<?php
$works = $this->renderPartial('grid-works', array('model' => $model, 'mdlWorks' => Acts::model()->mdlWorks($model->order_id,$model->id)), true);
//$works .= "\n";
//$works .= $this->renderPartial('grid-works_act', array('model' => $model, 'mdlWorksAct' => Acts::model()->mdlWorks($model->order_id,$model->id)), true);
echo $this->renderPartial('_form', array('model'=>$model,'works'=>$works));
?>