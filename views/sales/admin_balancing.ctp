<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales','/admin/sales'); ?>
<?php echo $this->Html->addCrumb('Semi-Monthly Balancing Sheet'); ?>
<div ng-controller="AdminSemiMonthlyReportController" ng-init="initializeController()">	
	<div class="panel panel-success" ng-form="SalesReportForm">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-3">
					<label for="customer">Customer</label>
					<select ng-model="customer" ng-options="d.Customer.name for d in customers" class="form-control input-sm" ng-required="true" ng-change="changeFilter(customer,inclusive_month,inclusive_date)">
						<option value="">-- Select --</option>
					</select>
				</div>
				<div class="col-lg-3">
					<label>Month</label>
					<input type="month" ng-model="inclusive_month" class="form-control input-sm" ng-required="true" ng-change="changeFilter(customer,inclusive_month,inclusive_date)">
				</div>
				<div class="col-lg-2">
					<label for="date">Inclusive Dates</label>
					<select ng-model="inclusive_date" ng-options="d.InclusiveDate.name for d in inclusive_dates" class="form-control input-sm" ng-required="true" ng-change="changeFilter(customer,inclusive_month,inclusive_date)">
						<option value="">-- Select --</option>
					</select>
				</div>
			</div><br/>
			<div class="row" ng-if="is_posted == false">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table class="table table-striped table-bordered table-condensed" >
						<thead>
							<tr>
								<th >Item Description</th>
								<th class="text-center w8">
									Beginning Inventory
								</th>
								<th class="text-center w8">Delivered</th>
								<th class="text-center w8">Returned</th>
								<th class="text-center w8">Inventory</th>
								<th class="text-center w8">Sold</th>
								<th class="text-center w8">Ending Inventory</th>
								<th class="text-center w8">Over Sold</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="data.length" ng-repeat="(i,d) in data">
								<td>{{d.Product.name}}</td>
								<td class="text-center">{{d.Product.beginning_inventory}}</td>
								<td class="text-center">{{d.delivered}}</td>
								<td class="text-center">{{d.returned}}</td>
								<td class="text-center">{{d.total_inventory}}</td>
								<td class="text-center">
									<input ng-required="true" type="number" class="form-control input-sm" ng-model="data[i].sold" ng-change="changeSold(i,d)"></input>
								</td>
								<td class="text-center">
									<div ng-if="data[i].ending_inventory">{{data[i].ending_inventory}}</div>
									<div ng-if="!data[i].ending_inventory">0</div>
								</td>
								<td class="text-center">
									<div ng-if="data[i].over_sold">{{data[i].over_sold}}</div>
									<div ng-if="!data[i].over_sold">0</div>
								</td>
							</tr>

							<tr ng-if="!data.length">
								<td colspan="9">No Data Available</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row" ng-if="is_posted == true">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table class="table table-striped table-bordered table-condensed" >
						<thead>
							<tr>
								<th>Item Description</th>
								<th class="text-center w8">Beginning Inventory</th>
								<th class="text-center w8">Delivered</th>
								<th class="text-center w8">Returned</th>
								<th class="text-center w8">Sold</th>
								<th class="text-center w8"><h6>(Over Sold)</h6>+</th>
								<th class="text-center w8"><h6>(Posible In Stock)</h6>-</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="9">POSTED</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		
		</div>
		<div class="panel-footer">
			<div class="text-right">
				<a href="<?php echo $this->base;?>/admin/sales" class="btn btn-default" type="cancel">Cancel</a>
				<button ng-click="save()" class="btn btn-danger" ng-disabled="!SalesReportForm.$valid" ng-if="is_posted == false">Save</button>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_balancing',array('inline'=>false));?>
