<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales','/admin/sales'); ?>
<?php echo $this->Html->addCrumb('Create Semi-Monthly Report'); ?>
<div ng-controller="AdminSemiMonthlyReportController" ng-init="initializeController()">	
	<div class="panel panel-success" ng-form="SalesReportForm">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-3">
					<label for="costumer">Costumer</label>
					<select ng-model="costumer" ng-options="d.Costumer.name for d in costumers" class="form-control input-sm" ng-required="true" ng-change="changeFilter(costumer,inclusive_month,inclusive_date)">
						<option value="">-- Select --</option>
					</select>
				</div>
				<div class="col-lg-3">
					<label>Month</label>
					<input type="month" ng-model="inclusive_month" class="form-control input-sm" ng-required="true" ng-change="changeFilter(costumer,inclusive_month,inclusive_date)">
				</div>
				<div class="col-lg-2">
					<label for="date">Inclusive Dates</label>
					<select ng-model="inclusive_date" ng-options="d.InclusiveDate.name for d in inclusive_dates" class="form-control input-sm" ng-required="true" ng-change="changeFilter(costumer,inclusive_month,inclusive_date)">
						<option value="">-- Select --</option>
					</select>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th rowspan="2">Item Description</th>
								<th colspan="3" class="text-center">Quantity</th>
								<th colspan="2" class="text-center">Sale</th>
								<th rowspan="2" class="text-center w8">Missing Quantity</th>
								<th rowspan="2" class="actions text-center w5">Action</th>
							</tr>
							<tr>
								<th class="text-center w8">Delivered</th>
								<th class="text-center w8">Returned</th>
								<th class="text-center w8">Current</th>
								<th class="text-center w8">System Count</th>
								<th class="text-center w8">Actual</th>
							</tr>
							<tr>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="data.length" ng-repeat="(i,d) in data">
								<td>{{d.products.name}}</td>
								<td class="text-center">{{d[0].total_delivered}}</td>
								<td class="text-center">{{d[0].total_returned}}</td>
								<td class="text-center">{{d.products.current_quantity}}</td>
								<td class="text-center">{{d[0].system_count}}</td>
								<td class="text-center">
									<input ng-required="true" type="number" class="form-control input-sm" ng-model="data[i][0].actual" ng-change="changeActualSale(i,data[i])"></input>
								</td>
								<td class="text-center">{{data[i][0].missing_qty}}</td>
								<td class="actions text-center"></td>
							</tr>
							<tr ng-if="!data.length">
								<td colspan="8">No Data Available</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="text-right">
				<a href="<?php echo $this->base;?>/admin/sales" class="btn btn-default" type="cancel">Cancel</a>
				<button ng-click="save()" class="btn btn-danger" ng-disabled="!SalesReportForm.$valid">Save</button>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_semi_monthly',array('inline'=>false));?>
