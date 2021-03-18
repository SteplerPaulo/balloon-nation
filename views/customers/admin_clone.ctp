<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Customer','/admin/customers'); ?>
<?php echo $this->Html->addCrumb('Clone Products',''); ?>
<div ng-controller="CloneProductController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<h1 class="ng-cloak">{{customer}}</h1>
		</div>
	</div><br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="5">Clone Products</th>
						<th colspan="3">
							<input ng-model="q" class="form-control input-sm" placeholder="Search">
						</th>
					</tr>
					<tr>
						<th class="text-center">
							<input ng-disabled="!data.length" type="checkbox" ng-model="check_all" ng-change="checkAll(check_all)">
						</th>
						<th>SKU</th>
						<th class="text-right">Product Name</th>
						<th class="text-center w10">Min Qty</th>
						<th class="text-center w10">Purchase Price</th>
						<th class="text-center w10">Selling Price</th>
						<th class="text-center w10">Beginning Inventory</th>
						<th class="text-center w5">Status</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="(i,d) in data | filter:q" ng-if="data.length" class="ng-cloak">
						<td class="text-center">
							<input type="checkbox" ng-model="data[i].Product.checkbox" ng-change="check(i,data[i].Product.checkbox)">
						</td>
						
						<td>{{d.Product.item_code}}</td>
						<td class="text-right">{{d.Product.name}}</td>
						<td>
							<input 
								type="number" min="0"
								class="form-control input-sm" 
								string-to-number required="required" 
								maxlength="11" ng-model="data[i].Product.min"
								ng-required="!data[i].Product.is_disabled" ng-disabled="data[i].Product.is_disabled"
							/>
						</td>
						<td>
							<input 
								type="number" min="0" step="0.01" 
								class="form-control input-sm" required="required"
								string-to-number ng-model='data[i].Product.purchase_price'
								ng-required="!data[i].Product.is_disabled" ng-disabled="data[i].Product.is_disabled">
						</td>
						<td>
							<input 
								type="number" min="0" step="0.01"
								class="form-control input-sm" required="required" 
								ng-model='data[i].Product.selling_price' string-to-number 
								ng-required="!data[i].Product.is_disabled" ng-disabled="data[i].Product.is_disabled"
							/>
						</td>
						<td>
							<input 
								type="number" class="form-control input-sm" 
								string-to-number ng-model='data[i].Product.beginning_inventory' ng-change="change(i)"
								ng-required="!data[i].Product.is_disabled" ng-disabled="data[i].Product.is_disabled"
							/>
						</td>
						<td class="text-center">{{data[i].Product.status}}</td>
						<td class="hide"><input class="form-control input-sm" ng-model='data[i].Product.initial_inventory'></td>
					</tr>
					<tr ng-if="!data.length && !loading" class="ng-cloak">
						<td colspan="8">
							No New Product
						</td>
					</tr>
					<tr ng-show="loading" class="ng-cloak">
						<td colspan="8">
							<center>
								<img class="loading"src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="8" class="text-right">
							<a href="<?php echo $this->base;?>/admin/customers" class="btn btn-default" type="cancel">Cancel</a>
							<button class="btn btn-danger" type="button" ng-disabled="!data.length || preventDoubleClick" ng-click="save()">Save</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/clone_products',array('inline'=>false));?>