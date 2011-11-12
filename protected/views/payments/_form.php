<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php echo $form->dropDownList($model, 'client_id', CHtml::listData(Clients::model()->findAll(),'id','name'),array('empty'=>'')); ?>
		<span class="note" style="display: block" id="ajax_mess"></span>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'order_id'); ?>
		<?php echo $form->dropDownList($model, 'order_id', array(),array('disabled'=>'disabled')); ?>
		<span class="note" style="display: block" id="ajax_order_mess"></span>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_id'); ?>
		<?php echo $form->dropDownList($model, 'invoice_id', array(),array('disabled'=>'disabled')); ?>
	</div>

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
		<?php echo $form->labelEx($model,'sum'); ?>
		<?php echo $form->textField($model,'sum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>3, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common.js');
Yii::app()->clientScript->registerScript('change_pay_client', "

function change_pay_client()
{
	var client = $('#Payments_client_id').val();
	var order = $('#Payments_order_id');
	if(client.length == 0) {
		order.attr('disabled','disabled');
		order.clearSelect();
		$('#ajax_mess').text('');
		change_pay_order();		
  	}
	else {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: {client_id : client},
			url: '" . $this->createUrl('payments/changeclient') . "',
			beforeSend: (function(msg){ $('#ajax_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{//	alert(msg)			
				if (msg!='no')
				{
					order.fillSelect(msg).attr('disabled','');
					$('#ajax_mess').text('Готово!');
					change_pay_order();	
				}
				else
				{					
					$('#ajax_mess').text('Нет заказов.');
					order.clearSelect();
					change_pay_order();
				}				
			},
			error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
		});		
	}
	
}
function change_pay_order()
{
	var order = $('#Payments_order_id').val();
	var invoice = $('#Payments_invoice_id');
	
	if(order==null||order.length == 0) {
			invoice.attr('disabled','disabled');
			invoice.clearSelect();
			$('#ajax_order_mess').text('');
		}	
	else {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: {order_id:order},
			url: '" . $this->createUrl('payments/changeorder') . "',
			beforeSend: (function(msg){ $('#ajax_order_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{
				if (msg!='no')
				{
					invoice.fillSelect(msg).attr('disabled','');					
					$('#ajax_order_mess').text('Готово!');
				}
				else
				{					
					invoice.clearSelect();
					$('#ajax_order_mess').text('Нет счетов.');			
				}								
			},
			error: function(msg, stat){ $('#ajax_order_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
		});
	}
	
}
	$('#Payments_client_id').change(function(){change_pay_client()}).change();
	$('#Payments_order_id').change(change_pay_order);
");