<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id' => 'works-form',
				'enableAjaxValidation' => false,
			));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'date'); ?>
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
	<?php echo $form->labelEx($model, 'order_id'); ?>
<?php echo $form->dropDownList($model, 'order_id', Orders::model()->listData(), array('encode' => false)); ?>
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
		<?php echo $form->textField($model, 'unit', array('size' => 60, 'maxlength' => 255, 'value' => 'шт.')); ?>
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