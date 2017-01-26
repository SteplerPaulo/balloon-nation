<div class="inquiries form">
<?php echo $this->Form->create('Inquiry');?>
	<fieldset>
		<legend><?php __('Admin Add Inquiry'); ?></legend>
	<?php
		echo $this->Form->input('from');
		echo $this->Form->input('subject');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Inquiries', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Inquiry Files', true), array('controller' => 'inquiry_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry File', true), array('controller' => 'inquiry_files', 'action' => 'add')); ?> </li>
	</ul>
</div>