<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products','/admin/products'); ?>
<?php echo $this->Html->addCrumb('Images'); ?>
<?php echo $this->Html->css('aboutus'); ?>
<style>
#ProductImageCaption{
	resize:none;
}
</style>


<div ng-controller="AdminProductImagesController" ng-init="initializeController()">	
	<div class="row">
		
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
			<h4>Photos of {{ProductName}}</h4>
		</div>
		<div class="col-lg-3 col-md-9 col-sm-12 col-xs-12">
			<button type="button" class="btn btn-warning btn-sm pull-right" ng-click="addPhoto()">
				Add Photo
			</button>
		</div>
	</div><br/>
	
	<div class="row" id="portfolio">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"  pagination-id="ProductImages" dir-paginate="img in d.ProductImage | filter:r | itemsPerPage: pageSize">
			<div>
				<span ng-if="img.caption">{{img.caption}}</span> 
				<span ng-if="!img.caption" class="text-muted">No caption </span> 
				<span class="pull-right">
					<a href="<?php echo $this->base;?>/admin/product_images/delete/id:{{img.id}}/product_slug:{{ProductSlug}}" onclick="return confirm('Are you sure you want to delete this photo?');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
				</span>
			</div>
			<div class="portfolio-item">
				<a ng-click="editImageCaption(img)" class="portfolio-link">
					<div class="caption">
						<div class="caption-content">
							<i class="fa fa-edit fa-3x"></i>
						</div>
					</div>
					<img src="<?php echo $this->base;?>/img/product images/{{img.img_file}}" class="img-responsive img-thumbnail" alt="" style="height:200px; width:340px;">
				</a>
			</div>
		</div>
	</div>

	
	
	
	<!-- Modal -->
	<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="ModalLabel">{{ModalLabel}}</h4>
				</div>
				<?php echo $form->create('ProductImage',array('type' => 'file','action'=>'admin_add')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 hide">
							<?php
								echo $this->Form->input('id',array('ng-model'=>'ImageID','label'=>'Image ID','type'=>'text','class'=>'form-control'));
							?>
							<?php
								echo $this->Form->input('product_id',array('ng-model'=>'ProductID','type'=>'text','class'=>'form-control'));
							?>
							<?php
								echo $this->Form->input('product_slug',array('ng-model'=>'ProductSlug','type'=>'text','class'=>'form-control'));
							?>
						</div>
					</div>
					<div class="row" ng-if="!isEdit">
						<div class="col-lg-12">
							<?php echo $form->input('img_file', array('type' => 'file','required'=>'required'));?>
						</div>
					</div><br/>
					<div class="row">
						<div class="col-lg-12">
							<?php echo $this->Form->input('caption',array('type'=>'textarea','ng-model'=>'ImageCaption','class'=>'form-control','rows'=>'4'));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Save</button>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_product_images',array('inline'=>false));?>