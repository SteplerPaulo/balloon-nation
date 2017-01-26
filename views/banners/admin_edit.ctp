<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Banners','/admin/banners/'); ?>
<?php echo $this->Html->addCrumb('Edit'); ?>
<style>
#BannerCaption{
	resize:none;
}	
</style>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="login-panel panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">	
					<h4>EDIT BANNER</h4>
				</h3>
			</div>
			<?php echo $this->Form->create('Banner',array('type' => 'file'));?>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-8 text-center">
						<img src="<?php echo $this->base;?>/img/banner/<?php echo $this->data['Banner']['img_file'];?>" class="img-responsive img-thumbnail" alt="">
					</div>
					<div class="col-lg-4">
						<?php echo $form->input('is_active', array('options' => array('1'=>'Activate','0'=>'Deactivate'),'label'=>'Status','class'=>'form-control'));?>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->Form->input('name',array('class'=>'form-control','required'=>'required','autocomplete'=>'off'));?>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->Form->input('caption',array('type'=>'textarea','class'=>'form-control','rows'=>'3'));?>
					</div>
				</div>
			</div>
			<div class="panel-footer">	
				<div class="text-right">
					<a href="<?php echo $this->base;?>/admin/banners" class="btn btn-default" type="cancel">Cancel</a>
					<button class="btn btn-danger" type="submit">Update</button>
				</div>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>