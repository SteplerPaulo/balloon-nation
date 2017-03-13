<div class="inquiryFiles form">
<?php echo $this->Form->create('InquiryFile', array('enctype' => 'multipart/form-data'));?>
	<fieldset>
		<legend><?php __('Add Inquiry File'); ?></legend>
	<?php
		echo $this->Form->input('inquiry_id');
		echo $this->Form->input('file_name', array('type'=>'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>