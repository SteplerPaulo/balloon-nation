<div class="documents form">
	<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data','action'=>'upload'));?>
	<legend><?php __('Change Profile Picture'); ?></legend>
	<?php echo $this->Form->file('Document');?><br />
	<?php
		echo $this->Form->input('User.Document.id',array('value'=>$user['Document']['id'],'type'=>'hidden'));
		echo $this->Form->input('User.Document.user_id',array('value'=>$user['User']['id'],'type'=>'hidden'));
	?><br />
	<input class="btn btn-primary" type="submit" value="Upload Picture" />
	<?php echo $this->Form->end(); ?>
</div>