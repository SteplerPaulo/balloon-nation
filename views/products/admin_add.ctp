<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products','/admin/products/'); ?>
<?php echo $this->Html->addCrumb('Add'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">	
					<h4>ADD PRODUCT</h4>
				</h3>
			</div>
			<?php echo $this->Form->create('Product');?>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-4">
						<?php echo $this->Form->input('costumer_id',array('empty'=>'-- Select --','class'=>'form-control','required'=>'required'));?>
					</div>
					<div class="col-lg-3">
						<?php echo $this->Form->input('category_id',array('empty'=>'-- Select --','class'=>'form-control','required'=>'required'));?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<?php echo $this->Form->input('item_code',array('class'=>'form-control','required'=>'required','autocomplete'=>'off'));?>
					</div>
					<div class="col-lg-8">
						<?php echo $this->Form->input('name',array('label'=>'Description','class'=>'form-control','required'=>'required','autocomplete'=>'off'));?>
					</div>
					<div class="col-lg-2">
						<label for="ProductMin">Minimun Quantity</label>
						<input name="data[Product][min]" type="number" class="form-control" required="required" autocomplete="off" maxlength="11" id="ProductMin">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<label for="ProductPurchasePrice">Purchase Price</label>
						<input name="data[Product][purchase_price]" type="number" min="0" step="0.01" class="form-control" required="required">
					</div>
					<div class="col-lg-2">
						<label for="ProductSellingPrice">Selling Price</label>
						<input name="data[Product][selling_price]" type="number" min="0" step="0.01" class="form-control" required="required">
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
<?php echo $this->Html->script('biz/product_descriptions',array('inline'=>false));?>