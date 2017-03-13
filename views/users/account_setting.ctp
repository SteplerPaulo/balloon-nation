<div class="row">
	<div class="col-lg-12">
		<div class="col-md-4 col-md-offset-4">
			<?php echo $this->Form->create('User',array('action'=>'account_setting','inputDefaults' => array('class'=>'form-control','between'=>'<div class="form-group">','after'=>'</div>')));?>
					
			<h1 class="page-header"><?php __('Edit Account');?></h1>
			<?php
				echo $this->Form->input('id',array('value'=>$data['User']['id']));
				echo $this->Form->input('username',array('value'=>$data['User']['username']));
				echo $this->Form->input('current_password',array('type'=>'password','required'=>'required','value'=>false));
			?>
			<hr/>
			
			<div class="control-group">
				<label for="ChangePassword" class="control-label">Change Password</label>
				<div class="controls">
					<input type="checkbox" id="ChangePassword"> 
				</div>
			</div>
			<div id="NewPasswordWrapper">
				<?php
					echo $this->Form->input('new_password',array('disabled'=>'disabled','value'=>false,'type'=>'password'));
					echo $this->Form->input('re-type_new_password',array('disabled'=>'disabled','value'=>false,'type'=>'password'));
				?>
			</div>
			<hr/>
			
			<div class="control-group">
				<label for="ChangeInfo" class="control-label">Change Info</label>
				<div class="controls">
					<input type="checkbox" id="ChangeInfo"> 
				</div>
			</div>
			<div id="InfoWrapper">
				<?php
					echo $this->Form->input('last_name',array('value'=>$data['User']['last_name'],'disabled'=>'disabled','required'=>'required'));
					echo $this->Form->input('first_name',array('value'=>$data['User']['first_name'],'disabled'=>'disabled','required'=>'required'));
					echo $this->Form->input('middle_name',array('value'=>$data['User']['middle_name'],'disabled'=>'disabled'));
				?>	
			</div>
			<?php echo $this->Form->button('Submit', array('type'=>'button','id'=>'SubmitButton','class'=>'btn btn-danger','disabled'=>'disabled'));?>
			<?php echo $this->Form->button('Reset',array('type'=>'reset','id'=>'ResetButton','class'=>'btn'));?>
			<?php echo $this->Form->end();?>
		
			<span id="Notify" class="hide"></span>
			<div id="LoginUser" class="hide"><?php echo $access->getmy('username');?></div>
			<br/><br/><br/>
		</div>
	</div>
</div>

<?php
	echo $this->Html->script(array('biz/account_setting'),array('inline'=>false));
?>