<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php echo $form->dropDownList($model,'client_id',CHtml::listData(Clients::model()->findAll(), 'id', 'name')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Orders::model()->itemAlias('status'));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'attribute' => 'date',
			'model' => $model,
			'value'=>$model->date,
			'language'=>'ru',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => 'fold', 'changeYear' => true, 'changeMonth' => true, 'dateFormat' => 'yy-mm-dd',
			),
		));
//		echo $form->textField($model,'date');
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fixpay'); ?>
		<?php echo $form->textField($model,'fixpay'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->