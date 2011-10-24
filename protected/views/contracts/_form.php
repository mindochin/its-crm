<div class="wide form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id' => 'contracts-form',
				'enableAjaxValidation' => false,
			));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'num'); ?>
		<?php echo $form->textField($model, 'num', array('size' => 50, 'maxlength' => 50)); ?>
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
				'showAnim' => 'fold', 'changeYear' => true, 'changeMonth' => true, 'dateFormat' => 'yy-mm-dd', 'defaultDate' => date('Y-m-d')
			),
		));
//		echo $form->textField($model,'date');
		?>

	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'duedate'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'attribute' => 'duedate',
			'model' => $model,
			'value' => $model->duedate,
			'language' => 'ru',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold', 'changeYear' => true, 'changeMonth' => true, 'dateFormat' => 'yy-mm-dd',
			),
		));
//		echo $form->textField($model,'duedate');
		?>

	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'sum'); ?>
		<?php echo $form->textField($model, 'sum'); ?>

	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'autoprolonged'); ?>
		<?php echo $form->dropDownList($model, 'autoprolonged', Contracts::model()->itemAlias('autoprolonged')); ?>

	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'template_id'); ?>
		<?php echo $form->dropDownList($model, 'template_id', CHtml::listData(ContractsTmpl::model()->findAll(), 'id', 'name')); ?>

	</div>

	<div class="row">
		<?php echo CHtml::label('&nbsp', 'wysiwig') ?>
		<?php echo CHtml::button('Обновить окно редактора', array('type' => 'button', 'class' => 'button', 'id' => 'wysiwyg'));
		echo "<span id='ajax_mess'></span>"; ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'body'); ?>
		<?php
		$this->widget('application.extensions.tinymce.ETinyMce', array(
			'editorTemplate' => 'full',
			'model' => $model, # Data-Model
			'attribute' => 'body',
			'width' => '83%',
			'useCompression'=>false,
			'useSwitch'=>false,
		));
		?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'is_sign'); ?>
		<?php //echo $form->checkBox($model,'is_paid',array('uncheckValue'=>'','checked'=>$model->is_paid=='yes'?true:false)) ?>
		<?php echo $form->dropDownList($model,'is_sign',$model->itemAlias('is_sign')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'note'); ?>
		<?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'file'); ?>
		<?php echo $form->textField($model, 'file', array('size' => 60, 'maxlength' => 100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php echo $form->hiddenField($model, 'client_id');
		echo $form->hiddenField($model, 'order_id');
		$this->endWidget(); ?>

</div><!-- form -->
<?php
		Yii::app()->clientScript->registerScript('change_body', "
function change_body()
	{
		var data = {
			'template_id' : $('select[name=\"Contracts[template_id]\"] option:selected').val(),
			'date' : $('input[name=\"Contracts[date]\"]').val(),
			'duedate' : $('input[name=\"Contracts[duedate]\"]').val(),
			'name' : $('input[name=\"Contracts[name]\"]').val(),
			'num' : $('input[name=\"Contracts[num]\"]').val(),
			'sum' : $('input[name=\"Contracts[sum]\"]').val(),
			'order_id' :".$model->order_id.",
		}
		
		$.ajax({
			type: 'POST',
			//dataType: 'JSON',
			data: data,
			url: '" . $this->createUrl('contracts/changebody',array('order_id'=>$model->order_id)) . "',
			beforeSend: (function(msg){ $('#ajax_mess').text('ЖДИТЕ... '+msg.responseCode); }),
			success: function(msg, code)
			{//alert(data);				
				if (msg!='')
					{
						tinymce.get('Contracts_body').setContent((msg));
						$('#ajax_mess').text('ГОТОВО! '+code);
					}
				else $('#ajax_mess').text('Ожидаемые данные не получены');
			},
			error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
//			complete: function(msg){ $('#ajax_mess').text('ГОТОВО! '); }
		});
	}
	$('#wysiwyg').click(change_body);
	//$('#wysiwyg').click(alert('input[name=\"Contracts[date]\"]'));
	$('select[name=\"Contracts[template_id]\"]').change(change_body);
");
?>