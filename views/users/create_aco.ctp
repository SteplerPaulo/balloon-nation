
<div class="tab-content">
	<div class="users form col-lg-4 col-lg-offset-4">
		<?php echo $this->Form->create('User',array(
				'action'=>'create_aco',
				'class'=>'form-horizontal',
			));?>
		<fieldset>
			<legend><?php __('Create ACO (Access Control Object)'); ?></legend>						
				<?php
					echo $this->Session->flash('auth').'<br>';
					echo $this->Form->input('models',array('empty'=>'Select One','required'=>'required','class'=>'form-control'));
					
				?>
		</fieldset><br/>
		<?php echo $this->Form->submit(__('Submit', true), array('class'=>'btn'));?>
		<?php echo $this->Form->end();?>

	</div>	
</div>
