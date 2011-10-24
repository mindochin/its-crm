<?php
$this->breadcrumbs=array(
	'Работы\услуги'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Просмотреть работу\услугу', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление работами\услугами', 'url'=>array('admin')),
);
?>

<h1>Изменить работу\услугу #<?php echo $model->id; ?></h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>