<?php
$this->breadcrumbs=array(
	'Договора'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Управление договорами', 'url'=>array('admin')),
);
?>

<h1>Создать договор</h1>

<?php $this->widget('application.extensions.yii-flash.Flash', array(
    'keys'=>array('success','error','notice'),
    'htmlOptions'=>array('class'=>'flash'),
)); ?><!-- flashes -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>