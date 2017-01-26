<div class="inquiryFiles form">
<?php echo $this->Form->create('InquiryFile');?>
	<fieldset>
		<legend><?php __('Admin Add Inquiry File'); ?></legend>
	<?php
		echo $this->Form->input('inquiry_id');
		echo $this->Form->input('file_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Inquiry Files', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Inquiries', true), array('controller' => 'inquiries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry', true), array('controller' => 'inquiries', 'action' => 'add')); ?> </li>
	</ul>
</div>