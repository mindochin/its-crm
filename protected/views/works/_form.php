<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'works-form',
		'enableAjaxValidation' => false,
			));
	?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'date'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'attribute' => 'date',
			'model' => $model,
			'value' => $model->date,
			'language' => 'ru',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold', 'changeYear' => true, 'changeMonth' => true, 'dateFormat' => 'yy-mm-dd',
			),
		));
//		echo $form->textField($model,'date');
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'client_id'); ?>
		<?php echo $form->dropDownList($model, 'client_id', CHtml::listData(Clients::model()->findAll(),'id','name'),array('empty'=>'')); ?>
		<span class="note" style="display: block" id="ajax_mess"></span>
	</div>
	
	<div class="row">
		<?php $orders = $model->isNewRecord ? Orders::model()->open()->listData() : Orders::model()->listData($model->client_id);
			echo $form->labelEx($model, 'order_id'); ?>
		<?php echo $form->dropDownList($model, 'order_id', $orders, array('encode' => false,'empty'=>'')); ?>
		<span class="note" style="display: block" id="ajax_order_mess"></span>
	</div>
	
	<?php if (!$model->isNewRecord) {
		?>
		<div class="row">
			<?php echo $form->labelEx($model, 'act_id'); ?>
			<?php echo $form->dropDownList($model, 'act_id', Acts::model()->listData($model->order_id), array('encode' => false,'empty'=>'')); ?>
		</div>
	<?php } ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'unit'); ?>
		<?php echo $form->textField($model, 'unit',array('value'=>'шт.')); ?>
		<?php //echo $form->dropDownList($model, 'unit', Works::model()->itemAlias('unit')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'cost'); ?>
		<?php echo $form->textField($model, 'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'group'); ?>
		<?php echo $form->dropDownList($model, 'group', Works::model()->itemAlias('group')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'quantity'); ?>
		<?php echo $form->textField($model, 'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'location'); ?>
		<?php echo $form->textField($model, 'location', array('size' => 60, 'maxlength' => 100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common.js');
Yii::app()->clientScript->registerScript('change_work_client', "
function change_work_client()
{
	var client = $('#Works_client_id').val();
	var order = $('#Works_order_id');
	if(client.length == 0) {
		order.attr('disabled','disabled');
		order.clearSelect();
		$('#ajax_mess').text('');
		change_work_order();		
  	}
	else {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: {client_id : client},
			url: '" . $this->createUrl('works/changeclient') . "',
			beforeSend: (function(msg){ $('#ajax_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{//	alert(msg)			
				if (msg!='no')
				{
					order.fillSelect(msg).attr('disabled','');
					$('#ajax_mess').text('Готово!');
					change_work_order();	
				}
				else
				{					
					$('#ajax_mess').text('Нет заказов.');
					order.clearSelect();
					change_work_order();
				}				
			},
			error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
		});		
	}
	
}
function change_work_order()
{
	var order = $('#Works_order_id').val();
	var act = $('#Works_act_id');
	
	if(order==null||order.length == 0) {
			act.attr('disabled','disabled');
			act.clearSelect();
			$('#ajax_order_mess').text('');
		}	
	else {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: {order_id:order},
			url: '" . $this->createUrl('works/changeorder') . "',
			beforeSend: (function(msg){ $('#ajax_order_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{
				if (msg!='no')
				{
					act.fillSelect(msg).attr('disabled','');					
					$('#ajax_order_mess').text('Готово!');
				}
				else
				{					
					act.clearSelect();
					$('#ajax_order_mess').text('Нет счетов.');			
				}								
			},
			error: function(msg, stat){ $('#ajax_order_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
		});
	}	
}
	$('#Works_client_id').change(change_work_client);
	$('#Works_order_id').change(change_work_order);

");