<div class="costumers form">
<?php echo $this->Form->create('Costumer');?>
	<fieldset>
		<legend><?php __('Edit Costumer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('address');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Costumer.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Costumer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Costumers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>