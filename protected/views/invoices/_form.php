<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoices-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> необходимы.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord) :?>
	<div class="row">
		<?php echo $form->labelEx($model,'order_id'); ?>
		<?php echo $form->dropDownList($model, 'order_id', Orders::model()->open()->listData(),array('empty'=>'')); ?>
		<span class="note" style="display: block" id="ajax_mess"></span>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'act_id'); ?>
		<?php echo $form->dropDownList($model, 'act_id', array(),array('empty'=>'Выберите заказ')); ?>
		<span class="note" style="display: block" id="ajax_mess_act"></span>
	</div>

	<?php else :?>

	<div class="row">
		<?php echo $form->labelEx($model,'act_id'); ?>
		<?php echo $form->dropDownList($model, 'act_id', Acts::model()->listData($model->order_id)); ?>
	</div>

	<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'template_id'); ?>
		<?php echo $form->dropDownList($model, 'template_id', CHtml::listData(InvoicesTmpl::model()->findAll(),'id','name')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date');
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
	 ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sum'); ?>
		<?php echo $form->textField($model,'sum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num'); ?>
		<?php echo $form->textField($model,'num',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_paid'); ?>
		<?php //echo $form->checkBox($model,'is_paid',array('uncheckValue'=>'','checked'=>$model->is_paid=='yes'?true:false)) ?>
		<?php echo $form->dropDownList($model,'is_paid',$model->itemAlias('is_paid')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'is_sign'); ?>
		<?php //echo $form->checkBox($model,'is_paid',array('uncheckValue'=>'','checked'=>$model->is_paid=='yes'?true:false)) ?>
		<?php echo $form->dropDownList($model,'is_sign',$model->itemAlias('is_sign')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php		Yii::app()->clientScript->registerScript('change_order', "
function change_order()
	{
		var code = {
			'order_id' : $('select[name=\"Invoices[order_id]\"] option:selected').val(),
		}

		$.ajax({
			type: 'POST',
			//dataType: 'JSON',
			data: code,
			url: '" . $this->createUrl('invoices/changeorder') . "',
			beforeSend: (function(msg){ $('#ajax_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{//alert(msg);
				if (msg!='null')
				{
					$('#ajax_mess').text('Готово!');
					$(\"select[name='Invoices[act_id]'] option\").remove();
					$.each(eval(msg),function(i,item)	{
					$(\"select[name='Invoices[act_id]']\").append('<option value=\"'+item.optionKey+'\">'+item.optionValue+'</option>');
					});
					//$(\"select[name='Invoices[act_id]']\").html(options);

				}
				else
				{
					$(\"select[name='Invoices[act_id]'] option\").remove();
					$('#ajax_mess').text('Нет актов по этому заказу.');
				}
				change_act();
			},
			error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
		});
	}

function change_act()
	{
		$('#ajax_mess_act').text('');
		$('#Invoices_sum').val('');
		$('select[name=\"Invoices[act_id]\"] option:selected').each(function()
		{
			var code = {
				'act_id' : $(this).val(),
			}

			$.ajax({
				type: 'POST',
				//dataType: 'JSON',
				data: code,
				url: '" . $this->createUrl('invoices/changeact') . "',
				beforeSend: (function(msg){ $('#ajax_mess_act').text('ЖДИТЕ... '+msg.responseCode); }),
				success: function(msg, code)
				{//alert(msg);
					if (msg=='null')
					{

						$('#ajax_mess').text('Нет данных.');
					}
					else
					{
						$('#ajax_mess_act').text('Готово!');
						$('#Invoices_sum').val(msg);
					}
				},
				error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
			});
		});
	};
	$('select[name=\"Invoices[act_id]\"]').change(change_act);
	$('select[name=\"Invoices[order_id]\"]').change(change_order);
");