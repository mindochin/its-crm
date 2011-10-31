<div class="wide form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'invoices-tmpl-form',
		'enableAjaxValidation' => false,
		'focus' => array($model, 'name'),
	));
	?>

	<p class="note">Поля с <span class="required">*</span> необходимы.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php
		echo $form->labelEx($model, 'body');
//		$this->widget('application.extensions.tinymce.ETinyMce', array(
//			'editorTemplate' => 'full',
//			'model' => $model, # Data-Model
//			'attribute' => 'body',
//			'width' => '83%',
//			'useCompression' => false,
//			'useSwitch' => false,
//			'contentCSS' =>Yii::app()->request->baseUrl . '/css/' . Yii::app()->config->get('global.style') . '/print.css',
//		));
		$this->widget('ext.yiiext.widgets.markitup.EMarkitupWidget', array(
			// можно использовать как для поля модели
			'model' => $model,
			'attribute' => 'body',
//			'name'=>'',
			'theme' => 'markitup',
			'settings' => 'html',
			'options' => array('nameSpace' => 'html'),
		))
		?>

	</div>

	<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->