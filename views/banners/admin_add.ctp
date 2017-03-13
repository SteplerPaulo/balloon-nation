<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Banners','/admin/banners/'); ?>
<?php echo $this->Html->addCrumb('Add'); ?>
<style>
#BannerCaption{
	resize:none;
}
.reminder{
	color:#d9534f;
}
</style>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="login-panel panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">	
					<h4>ADD BANNER</h4>
				</h3>
			</div>
			<?php echo $this->Form->create('Banner',array('type' => 'file'));?>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-8">
						<?php echo $this->Form->input('name',array('class'=>'form-control','required'=>'required','autocomplete'=>'off'));?>
					</div>
					<div class="col-lg-4">
						<?php echo $form->input('is_active', array('options' => array('1'=>'Activate','0'=>'Deactivate'),'label'=>'Status','class'=>'form-control'));?>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-lg-12">
						<?php echo $form->input('img_file', array('type' => 'file','required'=>'required'));?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 reminder">
						Image Size Must Be 950 width x 350 height
					</div>
				</div><br/>
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->Form->input('caption',array('type'=>'textarea','class'=>'form-control','rows'=>'4'));?>
					</div>
				</div>
			</div>
			<div class="panel-footer">	
				<div class="text-right">
					<a href="<?php echo $this->base;?>/admin/banners" class="btn btn-default" type="cancel">Cancel</a>
					<button class="btn btn-danger" type="submit">Save</button>
				</div>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>