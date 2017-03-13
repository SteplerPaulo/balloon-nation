<div class="inquiries form">
<?php echo $this->Form->create('Inquiry');?>
	<fieldset>
		<legend><?php __('Admin Edit Inquiry'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Inquiry.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Inquiry.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Inquiries', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Inquiry Files', true), array('controller' => 'inquiry_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry File', true), array('controller' => 'inquiry_files', 'action' => 'add')); ?> </li>
	</ul>
</div>