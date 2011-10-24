<a name="<acts"></a>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'acts-grid',
	'dataProvider' => $dtprv,
//	'filter'=>$model,
	'columns' => array(
		'id',
		'date',
		'sum',
		'num',
		array('name'=>'is_sign','value'=>'Acts::model()->itemAlias("is_sign",$data->is_sign)'),
		array(
			'class' => 'MyButtonColumn',
			'deleteButtonUrl' => 'Yii::app()->createUrl("acts/delete", array("id"=>$data->id))',
			'viewButtonUrl' => 'Yii::app()->createUrl("acts/view", array("id"=>$data->id))',
			'updateButtonUrl' => 'Yii::app()->createUrl("acts/update", array("id"=>$data->id))',
		),
	),
	'ajaxUpdate' => false,
));
echo CHtml::link('<span class="icon addnew">Создать акт</span>', Yii::app()->createUrl('acts/create', array('byorder' => $model->id)), array('class' => 'button'));
?>
