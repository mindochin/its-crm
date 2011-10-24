<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'invoices-grid',
		'dataProvider' => $dtprv,
//	'filter'=>$model,
		'columns' => array(
			'id',
			'date',
			'num',
			array('header'=>'Аст #','name'=>'act_id'),
			array('name'=>'is_paid','value'=>'Invoices::model()->itemAlias("is_paid",$data->is_paid)'),
			array('name'=>'is_sign','value'=>'Invoices::model()->itemAlias("is_sign",$data->is_sign)'),
			array(
				'class' => 'MyButtonColumn',
				'deleteButtonUrl' => 'Yii::app()->createUrl("invoices/delete", array("id"=>$data->id))',
				'viewButtonUrl' => 'Yii::app()->createUrl("invoices/view", array("id"=>$data->id))',
				'updateButtonUrl' => 'Yii::app()->createUrl("invoices/update", array("id"=>$data->id))',
			),
		),
		'ajaxUpdate'=>false,
	));
	echo CHtml::link('<span class="icon addnew">Создать счет</span>', array('invoices/create', 'byorder' => $model->id), array('class' => 'button'));

?>
