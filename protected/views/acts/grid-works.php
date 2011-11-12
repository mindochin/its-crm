<?php $works_sum = Works::model()->sumByOrder($mdlWorks) ?>
<p>Работы/услуги (без заказов/в заказе - неактированные/в акте/):</p>
<?php
$false=$model->isNewRecord ? 'false' : '$data->act_id=='.$model->id.' ? true : false';
//Dumper::d($_POST);
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'works-grid',
//	'cssFile' => false,
	'dataProvider' => $mdlWorks,
	'selectableRows' => null,
//	'updateSelector'=>':checkbox, th a, div .pager',
//	'filter'=>$mdlWorks,
	'columns' => array(
		'id', 'date', 'location', 'name', 'unit',
		array('name' => 'quantity', 'footer' => 'ИТОГО', 'footerHtmlOptions' => array('class' => 'strong a-right'),'htmlOptions'=>array('class'=>'qnt')),
		array('name' => 'cost', 'footer' => $works_sum, 'footerHtmlOptions' => array('class' => 'strong'),'htmlOptions'=>array('class'=>'cost')),
		array('class' => 'CCheckBoxColumn', 'header' => 'Вкл', 'name' => 'id','checkBoxHtmlOptions'=>array('name'=>'Works[]'),
			//'checked'=>'isset($_POST) ? (array_key_exists("Works",$_POST) ? (in_array($data->id,$_POST["Works"]) ? true:'.$false.') : '.$false.') : '.$false),
		'checked'=>'isset($_POST["Works"]) ? (in_array($data->id,$_POST["Works"]) ? true:'.$false.') : '.$false),
		),
//	'ajaxUpdate' => true,
));
?>
