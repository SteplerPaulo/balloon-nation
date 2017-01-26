<div class="productTransactions form">
<?php echo $this->Form->create('ProductTransaction');?>
	<fieldset>
		<legend><?php __('Add Product Transaction'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('product_id');
		echo $this->Form->input('added');
		echo $this->Form->input('subtracted');
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Product Transactions', true), array('action' => 'index'));?></li>
	</ul>
</div>