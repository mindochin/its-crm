<?php
$this->pageTitle=Yii::app()->name . ' - Контакты';
$this->breadcrumbs=array(
	'Контакты',
);
$this->menu = array(
	array('label' => 'Список статей', 'url' => array('article/index'), 'visible'=>Yii::app()->user->checkAccess('article.index')),
	array('label' => 'Создать статью', 'url' => array('article/create'), 'visible'=>Yii::app()->user->checkAccess('article.create')),
	array('label' => 'Изменить статью', 'url' => array('article/update', 'id' => $content->id), 'visible'=>Yii::app()->user->checkAccess('article.update')),
	array('label' => 'Удалить статью', 'url' => '#', 'linkOptions' => array('submit' => array('article/delete', 'id' => $content->id), 'confirm' => 'Are you sure you want to delete this item?'), 'visible'=>Yii::app()->user->checkAccess('article.delete')),
	array('label' => 'Управлять статьями', 'url' => array('article/admin'), 'visible'=>Yii::app()->user->checkAccess('article.admin')),
	);
?>

<h1>Контакты</h1>


<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php //else: ?>
<?php endif; ?>

<?php if ($content !== null) echo $content->intro; ?>

<p>Если у Вас есть деловые запросы или другие вопросы, пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Поля с <span class="required">*</span> необходимы.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<?php if(CCaptcha::checkRequirements() and 1==0):  // ;)?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

