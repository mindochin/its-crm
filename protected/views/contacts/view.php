<?php
$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Действительно удалить?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Просмотр контакта #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name' => 'client_id', 'value' => $model->client->name),
		'name',
		'post',
		'birthday',
		'address',
		'phone',
		'email',
		'icq',
		'note',		
	),
)); ?>
