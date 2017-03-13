<div class="productTransactions index">
	<h2><?php __('Product Transactions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('product_id');?></th>
			<th><?php echo $this->Paginator->sort('added');?></th>
			<th><?php echo $this->Paginator->sort('subtracted');?></th>
			<th><?php echo $this->Paginator->sort('date');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($productTransactions as $productTransaction):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $productTransaction['ProductTransaction']['id']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['name']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['product_id']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['added']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['subtracted']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['date']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['created']; ?>&nbsp;</td>
		<td><?php echo $productTransaction['ProductTransaction']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $productTransaction['ProductTransaction']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $productTransaction['ProductTransaction']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $productTransaction['ProductTransaction']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productTransaction['ProductTransaction']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Product Transaction', true), array('action' => 'add')); ?></li>
	</ul>
</div>