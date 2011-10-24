<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'contracts-grid',
	'cssFile' => false,
	'dataProvider' => $dtprv,
//	'filter'=>$model,
	'columns' => array(
		'id',
		'date',
		'name',
		array('name'=>'is_sign','value'=>'Contracts::model()->itemAlias("is_sign",$data->is_sign)'),
		array(
			'class' => 'MyButtonColumn',
			'deleteButtonUrl' => 'Yii::app()->createUrl("contracts/delete", array("id"=>$data->id))',
			'viewButtonUrl' => 'Yii::app()->createUrl("contracts/view", array("id"=>$data->id))',
			'updateButtonUrl' => 'Yii::app()->createUrl("contracts/update", array("id"=>$data->id,"byorder"=>$data->order_id))',
		),
	),
	'ajaxUpdate'=>false,
));
echo CHtml::link('<span class="icon addnew">Создать договор</span>',Yii::app()->createUrl('contracts/create',array('byorder'=>$model->id)),array('class'=>'button'));

?>
