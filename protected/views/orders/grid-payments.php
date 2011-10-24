<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'payments-grid',
		'dataProvider' => $dtprv,
//	'filter'=>$model,
		'columns' => array(
			'id', 'date', 'amount',
			'order_id',
			array('name'=>'client_id','value'=>'$data->client->name'),
			'invoice_id',
			array(
				'class' => 'MyButtonColumn',
				'deleteButtonUrl' => 'Yii::app()->createUrl("payments/delete", array("id"=>$data->id))',
				'viewButtonUrl' => 'Yii::app()->createUrl("payments/view", array("id"=>$data->id))',
				'updateButtonUrl' => 'Yii::app()->createUrl("payments/update", array("id"=>$data->id))',
			),
		),
		'ajaxUpdate'=>false,
	));
	echo CHtml::link('<span class="icon addnew">Создать проплату</span>', Yii::app()->createUrl('payments/create', array('byorder' => $model->id)), array('class' => 'button'));

?>
