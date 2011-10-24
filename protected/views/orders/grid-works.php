<p>Неотраженныв в актах работы/услуги на сумму: <strong><?php $ws=$dtprv->getData(); echo isset($ws[0]) ? $ws[0]->works_sum_order : '0' ?></strong></p>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'works-grid',
	'cssFile' => false,
	'dataProvider' => $dtprv,
//	'filter'=>$model,
	'columns' => array(
		'id', 'date', 'location', 'name', 'unit',
		array('name'=>'quantity','footer'=>'ИТОГО','footerHtmlOptions'=>array('class'=>'strong a-right')),
		array('name'=>'cost','footer'=>Works::model()->sumByOrder($dtprv),'footerHtmlOptions'=>array('class'=>'strong')),
		array(
			'class' => 'MyButtonColumn',
			'deleteButtonUrl' => 'Yii::app()->createUrl("works/delete", array("id"=>$data->id))',
			'viewButtonUrl' => 'Yii::app()->createUrl("works/view", array("id"=>$data->id))',
			'updateButtonUrl' => 'Yii::app()->createUrl("works/update", array("id"=>$data->id,"byorder"=>$data->order_id))',
		),
	),
	'ajaxUpdate'=>false,
));
echo CHtml::link('<span class="icon addnew">Создать работу</span>',Yii::app()->createUrl('works/create',array('byorder'=>$model->id)),array('class'=>'button'));
?>
