<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Customer','/admin/customers'); ?>
<?php echo $this->Html->addCrumb('Clone Main Products',''); ?>
<div ng-controller="CloneProductController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<h1>{{customer}}</h1>
		</div><!--
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-6 col-md-offset-6 col-xs-offset-6">
			<label>Items per page</label>
			<input type="number" min="1" max="100" class="form-control input-sm" ng-model="pageSize">
		</div>-->
	</div><br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="3">Clone Products</th>
						<th colspan="3">
							<input ng-model="q" class="form-control input-sm" placeholder="Search">
						</th>
					</tr>
					<tr>
						<th>Compcode</th>
						<th class="text-right">Product Name</th>
						<th class="text-center w10">Min Qty</th>
						<th class="text-center w10">Purchase Price</th>
						<th class="text-center w10">Selling Price</th>
						<th class="text-center w10">Beginning Inventory</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="(i,d) in data | filter:q">
						<td>{{d.Product.item_code}}</td>
						<td class="text-right">{{d.Product.name}}</td>
						<td>
							<input type="number" min="0" class="form-control input-sm" string-to-number required="required" maxlength="11" ng-model="data[i].Product.min">
						</td>
						<td>
							<input type="number" min="0" step="0.01" class="form-control input-sm" string-to-number required="required" ng-model='data[i].Product.purchase_price'>
						</td>
						<td>
							<input type="number" min="0" step="0.01" class="form-control input-sm" string-to-number required="required" ng-model='data[i].Product.selling_price'>
						</td>
						<td><input type="number" class="form-control input-sm" string-to-number ng-model='data[i].Product.beginning_inventory' ng-change="change(i)"></td>
						<td class="hide"><input class="form-control input-sm" ng-model='data[i].Product.initial_inventory'></td>
					</tr>
					<tr ng-show="loading">
						<td colspan="7">
							<center>
								<img class="loading"src="/balloon-nation/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="text-right">
							<a href="<?php echo $this->base;?>/admin/customers" class="btn btn-default" type="cancel">Cancel</a>
							<button class="btn btn-danger" type="button" ng-click="save()">Save</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/clone_products',array('inline'=>false));?>