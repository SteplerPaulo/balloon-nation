<div class="deliveries form">
<?php echo $this->Form->create('Delivery');?>
	<fieldset>
		<legend><?php __('Edit Delivery'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('costumer_id');
		echo $this->Form->input('delivery_receipt_no');
		echo $this->Form->input('date');
		echo $this->Form->input('stock_clerk');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Delivery.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Delivery.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Deliveries', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Costumers', true), array('controller' => 'costumers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Costumer', true), array('controller' => 'costumers', 'action' => 'add')); ?> </li>
	</ul>
</div>