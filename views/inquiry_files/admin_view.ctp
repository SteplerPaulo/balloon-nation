<div class="inquiryFiles view">
<h2><?php  __('Inquiry File');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiryFile['InquiryFile']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Inquiry'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($inquiryFile['Inquiry']['id'], array('controller' => 'inquiries', 'action' => 'view', $inquiryFile['Inquiry']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('File Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $inquiryFile['InquiryFile']['file_name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Inquiry File', true), array('action' => 'edit', $inquiryFile['InquiryFile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Inquiry File', true), array('action' => 'delete', $inquiryFile['InquiryFile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inquiryFile['InquiryFile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Inquiry Files', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry File', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inquiries', true), array('controller' => 'inquiries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inquiry', true), array('controller' => 'inquiries', 'action' => 'add')); ?> </li>
	</ul>
</div>
