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
		<?php echo $form->labelEx($model, 'order_id'); ?>
		<?php echo $form->dropDownList($model, 'order_id', array());  //Orders::model()->open()->listData(), array('encode' => false,'empty'=>'')); ?>
	</div>
	<?php if (!$model->isNewRecord) {
		?>
		<div class="row">
			<?php echo $form->labelEx($model, 'act_id'); ?>
			<?php echo $form->textField($model, 'act_id'); ?>
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
<?php		Yii::app()->clientScript->registerScript('change_client', "
function change_client()
	{
		var code = {
			'client_id' : $('select[name=\"Works[client_id]\"] option:selected').val(),
		}

		$.ajax({
			type: 'POST',
			//dataType: 'JSON',
			data: code,
			url: '" . $this->createUrl('works/changeclient') . "',
			beforeSend: (function(msg){ $('#ajax_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{//alert(msg);
				if (msg!='null')
				{
					$('#ajax_mess').text('Готово!');
					$(\"select[name='Works[order_id]'] option\").remove();
					$.each(eval(msg),function(i,item)	{
					$(\"select[name='Works[order_id]']\").append('<option value=\"'+item.optionKey+'\">'+item.optionValue+'</option>');
					});
				}
				else
				{
					$(\"select[name='Works[order_id]'] option\").remove();
					$('#ajax_mess').text('Нет заказов.');
				}				
			},
			error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
		});
	}

	$('select[name=\"Works[client_id]\"]').change(change_client);
");