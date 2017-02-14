<div class="productPricings index">
	<h2><?php __('Product Pricings');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('product_id');?></th>
			<th><?php echo $this->Paginator->sort('purchase_price');?></th>
			<th><?php echo $this->Paginator->sort('selling_price');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($productPricings as $productPricing):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $productPricing['ProductPricing']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($productPricing['Product']['name'], array('controller' => 'products', 'action' => 'view', $productPricing['Product']['id'])); ?>
		</td>
		<td><?php echo $productPricing['ProductPricing']['purchase_price']; ?>&nbsp;</td>
		<td><?php echo $productPricing['ProductPricing']['selling_price']; ?>&nbsp;</td>
		<td><?php echo $productPricing['ProductPricing']['quantity']; ?>&nbsp;</td>
		<td><?php echo $productPricing['ProductPricing']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $productPricing['ProductPricing']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $productPricing['ProductPricing']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $productPricing['ProductPricing']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productPricing['ProductPricing']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Product Pricing', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>