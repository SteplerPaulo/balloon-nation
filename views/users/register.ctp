<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Register'); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Register</h3>
				</div>
				<div class="panel-body">
					<?php echo $this->Form->create('User',array('action'=>'register','inputDefaults' => array('label'=>false,'class'=>'form-control','between'=>'<div class="form-group">','after'=>'</div>')));?>
					<?php
						echo $this->Form->input('username',array('placeholder'=>'Username','required'=>'required'));
						echo $this->Form->input('password',array('placeholder'=>'Password','required'=>'required','value'=>false));
						echo $this->Form->input('confirm_password',array('placeholder'=>'Re-type Password','required'=>'required','value'=>false,'type'=>'password'));
					?>
					<hr/>
					<?php
						echo $this->Form->input('last_name',array('placeholder'=>'Last Name','required'=>'required'));
						echo $this->Form->input('first_name',array('placeholder'=>'First Name','required'=>'required'));
						echo $this->Form->input('middle_name',array('placeholder'=>'MiddleName','required'=>'required'));
					?>	
					<?php echo $this->Form->submit(__('Submit', true), array('id'=>'SubmitButton','class'=>'btn btn-lg btn-success btn-block'));?>
					<?php echo $this->Form->end();?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array('biz/register'),array('inline'=>false));
?>