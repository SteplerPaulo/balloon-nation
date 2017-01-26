<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Sign In'); ?>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Please Sign In</h3>
			</div>
			<div class="panel-body">
				 <?php echo $this->Form->create('User',array('inputDefaults' => array('label'=>false,'class'=>'form-control','between'=>'<div class="form-group">','after'=>'</div>')));?>
				 <?php
					echo $this->Session->flash('auth').'<br>';
					echo $this->Form->input('username',array('placeholder'=>'Username','required'=>'required'));
					echo $this->Form->input('password',array('placeholder'=>'Password','required'=>'required','onkeypress'=>'PasswordCapsLock(event)'));
				?>
				<?php echo $this->Form->submit(__('Login', true), array('class'=>'btn btn-lg btn-danger btn-block' ));?>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array('biz/login'),array('inline'=>false));
?>
