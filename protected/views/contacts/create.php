<?php
$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать контакт</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>