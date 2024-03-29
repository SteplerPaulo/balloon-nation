<div ng-controller="AdminForDeliveryController" ng-init="initializeController()">
	<div class="login-panel panel panel-warning" ng-form="DeliveryForm">
		<div class="panel-heading">
			<h3>Delivery Receipt</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<label>Customer</label>
					<input class="form-control"	placeholder="Enter customer's name" ng-required="true"				
						typeahead-on-select="onSelect($item, $model, $label)" 
						ng-model="customer" typeahead-show-hint="true"
						ng-blur="checkCustomerInput()"
						typeahead-min-length="2" typeahead-select-on-blur="true"
						uib-typeahead="d as d.Customer.name for d in customers | filter:$viewValue | limitTo:15">	
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<label>Address</label>
					<input ng-model="customer_address" class="form-control input-sm" readonly="readonly"></input>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-2">
					<label>D.R. No.</label>
					<input ng-model="dr_no" ng-required="true" class="form-control input-sm" ng-change='checkDuplicate(dr_no)' ng-class="(existingDRNo?'alert-danger':'')"></input>
				</div>
				<div class="col-lg-3">
					<label>Date</label>
					<input  ng-model="dateNow" ng-required="true" type="datetime-local" class="form-control input-sm" ></input>
				</div>
				<div class="col-lg-7">
					<label>Stock Clerk</label>
					<input  ng-model="stock_clerk" ng-required="true" class="form-control input-sm"></input>
				</div>
			</div><hr/>
			<div class="row">
				<div class="col-lg-7">
					<input id="ItemCode" ng-model="item_code" ng-change="checkItem(item_code)" placeholder="Enter SKU here to automatically select item..." class="form-control input-sm"></input>			
				</div>
				<div class="col-lg-3">
					<div class="checkbox">
					  <label>
						<input ng-click="showSelected()" ng-model="selected_item_only" type="checkbox" value="">
						Show selected items only <span class="ng-cloak">({{selected_item_count}})</span>
					  </label>
					</div>
				</div>
			</div>
			<table class="table table-responsive table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center w5">
							<input ng-disabled="!products.length" type="checkbox" ng-model="check_all" ng-change="checkAll(check_all)">
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
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading.gif"></img>
							</center>
						</td>
					</tr>
					<tr  class="ng-cloak" ng-if="!products.length && !loading">
						<td colspan="4">
							No data available.
						</td>
					</tr>
					<tr  class="ng-cloak" ng-if="!selected_item_count && selected_item_only">
						<td colspan="4">
							No selected item.
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