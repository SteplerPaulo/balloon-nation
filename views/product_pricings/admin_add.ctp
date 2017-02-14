<div class="productPricings form">
<?php echo $this->Form->create('ProductPricing');?>
	<fieldset>
		<legend><?php __('Admin Add Product Pricing'); ?></legend>
	<?php
		echo $this->Form->input('product_id');
		echo $this->Form->input('purchase_price');
		echo $this->Form->input('selling_price');
		echo $this->Form->input('quantity');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Product Pricings', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>