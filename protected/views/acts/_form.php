<div class="wide form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'acts-form',
		'enableAjaxValidation' => false,
//		'action'=>array('acts/changeBody'),
			));
	?>

	<p class="note">Поля с <span class="required">*</span> необходимы</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="span-12">

		<div class="row">
			<?php echo $form->labelEx($model, 'template_id'); ?>
			<?php echo $form->dropDownList($model, 'template_id', CHtml::listData(ActsTmpl::model()->findAll(), 'id', 'name')); ?>
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
			?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'num'); ?>
			<?php echo $form->textField($model, 'num'); ?>
		</div>

	</div>
	<div class="span-12 last">

		<div class="row">
			<?php echo $form->labelEx($model, 'note'); ?>
			<?php echo $form->textArea($model, 'note', array('rows' => 3, 'cols' => 50)); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'is_sign'); ?>
			<?php //echo $form->checkBox($model,'is_paid',array('uncheckValue'=>'','checked'=>$model->is_paid=='yes'?true:false)) ?>
			<?php echo $form->dropDownList($model,'is_sign',$model->itemAlias('is_sign')); ?>
		</div>

	</div>

	<div class="clear">&nbsp;</div>

	<div class="box">
		<?php echo $works; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'sum'); ?>
		<?php if ($model->order->fixpay ==null) echo $form->textField($model, 'sum'); else echo $form->textField($model, 'sum',array('readonly'=>'readonly')); ?>
	</div>	

	<div class="row">
		<?php echo CHtml::label('&nbsp', 'wysiwig'); ?>
		<?php echo CHtml::button('Обновить окно редактора', array('type' => 'button', 'class' => 'button', 'id' => 'wysiwyg')); ?>
		<span id='ajax_mess'></span>
	</div>

	<div class="row">
		<?php
		echo $form->labelEx($model, 'body');
		$this->widget('application.extensions.tinymce.ETinyMce', array(
			'editorTemplate' => 'full',
			'model' => $model, # Data-Model
			'attribute' => 'body',
			'width' => '83%',
			'useCompression' => false,
			'useSwitch' => false,
			'contentCSS' =>Yii::app()->request->baseUrl . '/css/' . Yii::app()->config->get('global.style') . '/print.css',
		));
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
	<?php
	echo $form->hiddenField($model, 'order_id');
	echo $form->hiddenField($model, 'client_id');
	echo $form->hiddenField($model, 'id');
	$this->endWidget();
	?>
</div>
<?php
if ($model->order->fixpay ==null)
Yii::app()->clientScript->registerScript('edit_work', "
function recalc()
{
	var totals = 0;
	//find all the checked checkboxes
	$('input[type=checkbox]:checked').each
	(
		function()
		{
			row=$(this).parents('tr').get(0);
			cost=parseFloat($('td.cost',row).text());
			quant=parseFloat($('td.qnt',row).text());
			sum = cost*quant;
			if (!isNaN(sum)) totals += sum;
		}
	);
	$('input[name=\"Acts[sum]\"]').val(totals.toFixed(2));
}
jQuery('body').undelegate(':checkbox','click').delegate(':checkbox','click',recalc);
");

Yii::app()->clientScript->registerScript('change_body', "
function change_body()
{
if ($('input[type=checkbox]:checked').length == 0) {alert('Выберите работу/услугу'); return false}

var data = {
		'template_id' : $('select[name=\"Acts[template_id]\"] option:selected').val(),
		'date' : $('input[name=\"Acts[date]\"]').val(),
		'num' : $('input[name=\"Acts[num]\"]').val(),
		'sum' : $('input[name=\"Acts[sum]\"]').val(),
		'client_id' :" . $model->client_id . ",
		'order_id' :" . $model->order_id . ",
		'act_id' :" . ($model->id ? $model->id : '0') . ",
		'works' : $('input[type=\"checkbox\"]:checked').serialize(),
	}

	$.ajax({
		type: 'POST',
		//dataType: 'JSON',
		data: data,
		url: '" . $this->createUrl('acts/changebody') . "',
		beforeSend: (function(msg){ $('#ajax_mess').text('ЖДИТЕ... '+msg.responseCode); }),
		success: function(msg, code)
		{//alert(data);
			if (msg!='')
				{
					tinymce.get('Acts_body').setContent((msg));
					$('#ajax_mess').text('ГОТОВО! '+code);
				}
			else $('#ajax_mess').text('Ожидаемые данные не получены');
		},
		error: function(msg, stat){ $('#ajax_mess').text('ОШИБКА = '+eval(msg.responseCode)+' = '+stat); },
//			complete: function(msg){ $('#ajax_mess').text('ГОТОВО! '); }
	});
}
$('#wysiwyg').click(change_body);
$('select[name=\"Acts[template_id]\"]').change(change_body);
");
?>