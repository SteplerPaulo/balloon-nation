<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Costumer','/admin/costumers/'); ?>
<?php echo $this->Html->addCrumb('Add'); ?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">	
					<h4>ADD COSTUMER</h4>
				</h3>
			</div>
			<?php echo $this->Form->create('Costumer');?>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php	echo $this->Form->input('name',array('class'=>'form-control','required'=>'required','autocomplete'=>'off'));?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<?php	echo $this->Form->input('address',array('class'=>'form-control','required'=>'required'));?>
					</div>
				</div>
			</div>
			<div class="panel-footer">	
				<div class="text-right">
					<a href="<?php echo $this->base;?>/admin/costumers" class="btn btn-default" type="cancel">Cancel</a>
					<button class="btn btn-danger" type="submit">Save</button>
				</div>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>