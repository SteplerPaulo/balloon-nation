<div class="inquiryFiles index">
	<h2><?php __('Inquiry Files');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('inquiry_id');?></th>
			<th><?php echo $this->Paginator->sort('file_name');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($inquiryFiles as $inquiryFile):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $inquiryFile['InquiryFile']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($inquiryFile['Inquiry']['id'], array('controller' => 'inquiries', 'action' => 'view', $inquiryFile['Inquiry']['id'])); ?>
		</td>
		<td><?php echo $inquiryFile['InquiryFile']['file_name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $inquiryFile['InquiryFile']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $inquiryFile['InquiryFile']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $inquiryFile['InquiryFile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inquiryFile['InquiryFile']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Inquiry File', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Inquiries', true), array('controller' => 'inquiries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry', true), array('controller' => 'inquiries', 'action' => 'add')); ?> </li>
	</ul>
</div>