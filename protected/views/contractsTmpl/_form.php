<div class="wide form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'contracts-tmpl-form',
		'enableAjaxValidation' => false,
		'focus'=>array($model,'name'),
			));
	?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

		<?php echo $form->errorSummary($model); ?>

	<div class="row">
<?php echo $form->labelEx($model, 'name'); ?>
<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php
		echo $form->labelEx($model, 'body');
		$this->widget('ext.yiiext.widgets.markitup.EMarkitupWidget', array(
			// можно использовать как для поля модели
			'model' => $model,
			'attribute' => 'body',
			'options' => array('nameSpace' => 'html'),
				// так и просто для элемента формы
//    'name' => 'my_input_name',
		))
		?>
	</div>

	<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->