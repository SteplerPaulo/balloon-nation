<style>
	i{cursor:pointer}
</style>
<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Deliveries','/admin/deliveries'); ?>
<?php echo $this->Html->addCrumb('Create Delivery',''); ?>
<div ng-controller="AdminForDeliveryController" ng-init="initializeController()">
	<div class="login-panel panel panel-success" ng-form="DeliveryForm">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-3">
					<label for="costumer">To</label>/Costumer
					<select class='form-control' ng-model='costumer' ng-required="true" ng-change="changeCostumer(costumer)">
						<option value="null">Select</option>
						<option ng-repeat="d in costumers" address="{{d.Costumer.address}}">{{d.Costumer.name}}</option>
					</select>
				</div>
				<div class="col-lg-5">
					<label>Address</label>
					<input ng-model="costumer_address" class="form-control input-sm" readonly="readonly"></input>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-lg-2">
					<label>DR No.</label>
					<input ng-model="dr_no" ng-required="true" class="form-control input-sm"></input>
				</div>
				<div class="col-lg-3">
					<label>Stock Clerk</label>
					<input ng-model="stock_clerk" ng-required="true" class="form-control input-sm"></input>
				</div>
				<div class="col-lg-3">
					<label>Date</label>
					<input ng-model="dateNow" ng-required="true" type="datetime-local" class="form-control input-sm" ></input>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th rowspan="2" class="text-center w5">
									<input type="checkbox" ng-model="check_all" ng-change="checkAll(check_all)">
								</th>
								<th rowspan="2" class="text-center">Description</th>
								<th colspan="2" class="text-center">System</th>
								<th colspan="3" class="text-center">Actual Quantity</th>
								<th colspan="2" class="text-center">Forecast Total</th>
								<th rowspan="2" class="text-center w5">Action</th>
							</tr>
							<tr>
							
								<th class="text-center w10">MOQ</th>
								<th class="text-center w10">Current</th>
								<th class="text-center w10">In Stock</th>
								<th class="text-center w10">Bad Item</th>
								<th class="text-center w10">Deliver</th>
								<th class="text-center w5">Returned</th>
								<th class="text-center w5">Delivered</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="products.length" ng-repeat="(i, o) in products">
								<td class="text-center"><input type="checkbox" ng-model="products[i].checkbox" ng-change="check(i,products[i].checkbox)"></td>
								<td>{{o.Product.name}}</td>
								<td class="text-center">{{o.Product.min}}</td>
								<td class="text-center" ng-class="(o.Product.current_quantity < o.Product.min)?'bg-warning':''">{{o.Product.current_quantity}}</td>
								<td class="text-center">
									<input ng-required="!products[i].is_disabled" ng-disabled="products[i].is_disabled" ng-model="products[i].counted" ng-change="toggleQty(i,products[i].counted,products[i].bad_item,products[i].deliver)" type="number" min="0" class="form-control input-sm"></input>
								</td>
								<td class="text-center">
									<input ng-required="!products[i].is_disabled" ng-disabled="products[i].is_disabled" ng-model="products[i].bad_item" ng-change="toggleQty(i,products[i].counted,products[i].bad_item,products[i].deliver)" type="number" min="0" class="form-control input-sm"></input>
								</td>
								<td class="text-center">
									<input ng-required="!products[i].is_disabled" ng-disabled="products[i].is_disabled" ng-model="products[i].deliver" ng-change="toggleQty(i,products[i].counted,products[i].bad_item,products[i].deliver)" type="number" min="0" class="form-control input-sm"></input>
								</td>
								<td class="text-center">
									{{products[i].UpdatedTotalReturned}}
								</td>
								<td class="text-center">
									{{products[i].UpdatedTotalDelivered}}
								</td>
								<td class="text-center">
									<a ng-click="undoChanges(i)" title="Undo changes"><i class="fa fa-undo" aria-hidden="true"></i></a>
								</td>
							</tr>
							<tr ng-if="!products.length">
								<td colspan="10">
									No data available. Please select costumer
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel-footer">	
			<div class="text-right">
				<a href="<?php echo $this->base;?>/admin/deliveries" class="btn btn-default" type="cancel">Cancel</a>
				<button ng-click="save()" class="btn btn-danger" ng-disabled="!DeliveryForm.$valid">Save</button>
			</div>
		</div>
	</div>

</div>
<?php echo $this->Html->script('controllers/admin_delivery',array('inline'=>false));?>