<div class="inquiries view">
<h2><?php  __('Inquiry');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiry['Inquiry']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('From'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiry['Inquiry']['from']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subject'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiry['Inquiry']['subject']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiry['Inquiry']['content']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiry['Inquiry']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Inquiry', true), array('action' => 'edit', $inquiry['Inquiry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Inquiry', true), array('action' => 'delete', $inquiry['Inquiry']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inquiry['Inquiry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Inquiries', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inquiry Files', true), array('controller' => 'inquiry_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry File', true), array('controller' => 'inquiry_files', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Inquiry Files');?></h3>
	<?php if (!empty($inquiry['InquiryFile'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Inquiry Id'); ?></th>
		<th><?php __('File Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($inquiry['InquiryFile'] as $inquiryFile):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $inquiryFile['id'];?></td>
			<td><?php echo $inquiryFile['inquiry_id'];?></td>
			<td><?php echo $inquiryFile['file_name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'inquiry_files', 'action' => 'view', $inquiryFile['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'inquiry_files', 'action' => 'edit', $inquiryFile['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'inquiry_files', 'action' => 'delete', $inquiryFile['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inquiryFile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Inquiry File', true), array('controller' => 'inquiry_files', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
