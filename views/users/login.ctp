
<div class="row">
	<div class="col-lg-4 col-lg-offset-2" >
		<h2 id="AppDescription">Balloon Republic <br/><strong>Invetory & Sales Report </strong> system</h2>

		<img src="<?php echo $this->base;?>/img/logo.png" class="img-responsive" alt="Balloon Republic"/>
		<div class="small text-muted">
			Balloon decorations, one stop shop for your party requirement. Have A hassle free party for a reasonable price that you can afford. Customized packages
		</div>
		
	</div>
	<div class="col-lg-4 vdivider">
		<div class="login-panel panel panel-default">
			<div class="panel-body">
				<img src="<?php echo $this->base;?>/img/name.png" class="img-responsive" alt="Balloon Republic"/>
				<hr/>
				<?php echo $this->Form->create('User',array('inputDefaults' => array('label'=>false,'class'=>'form-control','between'=>'<div class="form-group">','after'=>'</div>')));?>
				<?php
					echo $this->Session->flash('auth');
					echo $this->Form->input('username',array('placeholder'=>'Username','required'=>'required'));
					echo $this->Form->input('password',array('placeholder'=>'Password','required'=>'required','onkeypress'=>'PasswordCapsLock(event)'));
				?>
				<?php echo $this->Form->submit(__('Sign In', true), array('class'=>'btn btn-success btn-block'));?>
				<?php echo $this->Form->end();?>
				<br/>
				
				
				<a class="pull-left" href="<?php echo $this->base .'/'?>">Home</a>
				<a class="pull-right" href="<?php echo $this->base .'/users/register'?>">Create an account</a>
			</div>
			
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array('biz/login'),array('inline'=>false));
?>
