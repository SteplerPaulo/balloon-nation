<div class="deliveries index">
	<h2><?php __('Deliveries');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('costumer_id');?></th>
			<th><?php echo $this->Paginator->sort('delivery_receipt_no');?></th>
			<th><?php echo $this->Paginator->sort('date');?></th>
			<th><?php echo $this->Paginator->sort('stock_clerk');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($deliveries as $delivery):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $delivery['Delivery']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($delivery['Costumer']['name'], array('controller' => 'costumers', 'action' => 'view', $delivery['Costumer']['id'])); ?>
		</td>
		<td><?php echo $delivery['Delivery']['delivery_receipt_no']; ?>&nbsp;</td>
		<td><?php echo $delivery['Delivery']['date']; ?>&nbsp;</td>
		<td><?php echo $delivery['Delivery']['stock_clerk']; ?>&nbsp;</td>
		<td><?php echo $delivery['Delivery']['created']; ?>&nbsp;</td>
		<td><?php echo $delivery['Delivery']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $delivery['Delivery']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $delivery['Delivery']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $delivery['Delivery']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $delivery['Delivery']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Delivery', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Costumers', true), array('controller' => 'costumers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Costumer', true), array('controller' => 'costumers', 'action' => 'add')); ?> </li>
	</ul>
</div>