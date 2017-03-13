
<div class="tab-content">
		<div class="users form col-lg-4 col-lg-offset-4">
		<?php echo $this->Form->create('User',array(
				'action'=>'assigning_permission',
				'class'=>'form-horizontal',
				));?>
		<fieldset>
			<legend><?php __('Assigning Permmission'); ?></legend>						
				<?php
					echo $this->Session->flash('auth').'<br>';
					echo $this->Form->input('user_id',array('empty'=>'Select One','required'=>'required','class'=>'form-control'));
					echo $this->Form->input('roles',array('empty'=>'Select One','required'=>'required','class'=>'form-control'));
				?>
		</fieldset><br/>
		<?php echo $this->Form->submit(__('Submit', true), array('class'=>'btn'));?>
		<?php echo $this->Form->end();?>
			
	</div>	
</div>

