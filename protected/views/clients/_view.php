<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullname')); ?>:</b>
	<?php echo CHtml::encode($data->fullname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requisite')); ?>:</b>
	<?php echo CHtml::encode($data->requisite); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contactdata')); ?>:</b>
	<?php echo CHtml::encode($data->contactdata); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('headpost')); ?>:</b>
	<?php echo CHtml::encode($data->headpost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('headfio')); ?>:</b>
	<?php echo CHtml::encode($data->headfio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('headbasis')); ?>:</b>
	<?php echo CHtml::encode($data->headbasis); ?>
	<br />
	
</div>