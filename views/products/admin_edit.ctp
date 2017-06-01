<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products','/admin/products/'); ?>
<?php echo $this->Html->addCrumb('Edit'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">	
					<h4>EDIT PRODUCT</h4>
				</h3>
			</div>
			<?php echo $this->Form->create('Product');?>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-3">
						<?php echo $this->Form->input('customer_id',array('empty'=>'-- Select --','class'=>'form-control','required'=>'required','disabled'=>'disabled'));?>
						<?php echo $this->Form->input('customer_id',array('label'=>false,'class'=>'form-control hide','required'=>'required'));?>
						<?php echo $this->Form->input('Customer.name',array('label'=>false,'class'=>'form-control hide','required'=>'required'));?>
					</div>
					<div class="col-lg-3">
						<?php echo $this->Form->input('category_id',array('empty'=>'-- Select --','class'=>'form-control','required'=>'required'));?>
					</div>
					<div class="col-lg-3">
						<?php echo $this->Form->input('id',array('class'=>'form-control','type'=>'hidden'));?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						<?php echo $this->Form->input('item_code',array('class'=>'form-control','required'=>'required'));?>
					</div>
					<div class="col-lg-7">
						<?php echo $this->Form->input('name',array('label'=>'Item Description','class'=>'form-control','required'=>'required','autocomplete'=>'off'));?>
					</div>
					<div class="col-lg-2">
						<?php echo $this->Form->label('Minimun Quantity');?>
						<?php echo $this->Form->text('min',array('class'=>'form-control','required'=>'required','min'=>'0','type'=>'number'));?>	
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<?php echo $this->Form->label('Purchase Price');?>
						<?php echo $this->Form->text('purchase_price',array('class'=>'form-control','required'=>'required','min'=>'0','step'=>'0.01','type'=>'number'));?>	
					</div>
					<div class="col-lg-2">
						<?php echo $this->Form->label('Selling Price');?>
						<?php echo $this->Form->text('selling_price',array('class'=>'form-control','required'=>'required','min'=>'0','step'=>'0.01','type'=>'number'));?>	
					</div>
					<div class="col-lg-2">
						<?php echo $this->Form->label('Beginning Inventory');?>
						<?php echo $this->Form->text('beginning_inventory',array('class'=>'form-control','required'=>'required','min'=>'0','type'=>'number'));?>	
					</div>
				</div>
			</div>
			<div class="panel-footer">	
				<div class="text-right">
					<a href="<?php echo $this->base;?>/admin/products" class="btn btn-default" type="cancel">Cancel</a>
					<button class="btn btn-danger" type="submit">Save</button>
				</div>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>