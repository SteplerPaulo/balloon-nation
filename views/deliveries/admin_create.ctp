<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Deliveries','/admin/deliveries'); ?>
<?php echo $this->Html->addCrumb('Create',''); ?>
<div ng-controller="AdminForDeliveryController" ng-init="initializeController()">
	<div class="login-panel panel panel-success" ng-form="DeliveryForm">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-4">
					<label for="customer">To</label>/Customer
					<select class='form-control input-sm' ng-model='customer' ng-required="true" ng-change="changeCustomer(customer)">
						<option value="">-- Select --</option>
						<option class="ng-cloak" ng-repeat="d in customers" address="{{d.Customer.address}}">{{d.Customer.name}}</option>
					</select>
				</div>
				<div class="col-lg-8">
					<label>Address</label>
					<input ng-model="customer_address" class="form-control input-sm" readonly="readonly"></input>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-2">
					<label>DR No.</label>
					<input ng-model="dr_no" ng-required="true" class="form-control input-sm" ng-change='checkDuplicate(dr_no)' ng-class="(existingDRNo?'alert-danger':'')"></input>
				</div>
				<div class="col-lg-3">
					<label>Stock Clerk</label>
					<input  ng-model="stock_clerk" ng-required="true" class="form-control input-sm"></input>
				</div>
				<div class="col-lg-3">
					<label>Date</label>
					<input  ng-model="dateNow" ng-required="true" type="datetime-local" class="form-control input-sm" ></input>
				</div>
			</div><hr/>
			<div class="row">
				<div class="col-lg-9">
					<input id="ItemCode" ng-model="item_code" ng-change="checkItem(item_code)" placeholder="Enter SKU here to automatically select item..." class="form-control input-sm"></input>			
				</div>
				<div class="col-lg-3">
					<div class="checkbox">
					  <label>
						<input ng-click="showSelected()" ng-model="selected_item_only" type="checkbox" value="">
						Show selected items only
					  </label>
					</div>
				</div>
			</div>
			<table class="table table-responsive table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center w5">
							<input type="checkbox" ng-model="check_all" ng-change="checkAll(check_all)">
						</th>
						<th>Items</th>
						<th class="text-center w8">To Deliver</th>
						<th class="text-center w8">Bad Item(s)</th>
					</tr>
				</thead>
				<tbody>
					<tr class="ng-cloak" ng-hide="products[i].is_disabled && selected_item_only" ng-if="products.length && !loading" ng-repeat="(i, o) in products">
						<td class="text-center"><input type="checkbox" ng-model="products[i].checkbox" ng-change="check(i,products[i].checkbox)"></td>
						<td class="capitalize">
							{{o.Product.name}} 
							<div>
								<small class="text-muted">
									MOQ: {{o.Product.min}} |
									SKU: {{o.Product.item_code}}
								</small>
							</div>
						
						</td>
					
						<td class="text-center">
							<input ng-required="!products[i].is_disabled" ng-disabled="products[i].is_disabled" ng-model="products[i].deliver" type="number" min="0" class="form-control input-sm" placeholder="0"></input>
						</td>
						<td class="text-center">
							<input ng-required="!products[i].is_disabled" ng-disabled="products[i].is_disabled" ng-model="products[i].bad_item" type="number" min="0" class="form-control input-sm" placeholder="0"></input>
						</td>
					</tr>
					<tr  class="ng-cloak" ng-show="loading">
						<td colspan="4">
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr  class="ng-cloak" ng-if="!products.length && !loading">
						<td colspan="4">
							No data available. Please select customer
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<div class="text-right">
				<a href="<?php echo $this->base;?>/admin/deliveries" class="btn btn-default" type="cancel">Cancel</a>
				<button ng-click="save()" class="btn btn-danger" ng-disabled="!DeliveryForm.$valid || preventDoubleClick || existingDRNo">Submit</button>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_delivery',array('inline'=>false));?>