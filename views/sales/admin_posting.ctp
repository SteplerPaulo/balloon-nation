<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales','/admin/sales'); ?>
<?php echo $this->Html->addCrumb('Inventory Posting'); ?>
<div ng-controller="AdminSalePostingController" ng-init="initializeController()">
	<div class="panel panel-success" ng-form="SalesReportForm">
		<div class="panel-body" id="SalePostingPanel" sale-id="<?php echo $id;?>">
			<div class="row" ng-if="SaleID">
				<div class="col-lg-9">
					<label>Customer:</label>
					{{ data.Customer.name}}
				</div>
				<div class="col-lg-3">
					<label>Date:</label>
					{{ data.Sale.from_date |date:'MMMM yyyy'}} 
				</div>
			</div>
			<div class="row"  ng-if="!SaleID">
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
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th>Item Description</th>
								<th class="text-center w8">Beginning Inventory</th>
								<th class="text-center w8">Delivered</th>
								<th class="text-center w8">Returned</th>
								<th class="text-center w8">Sold</th>
								<th class="text-center w8">Over Sold</th>
								<th class="text-center w8">Ending Inventory</th>
								<th class="text-center w8">Actual Inventory</th>
								<th class="text-center w8">Missing Qty</th>
							</tr>
						</thead>
						<tbody>	
							<tr ng-repeat="(i,d) in data.SaleDetail">
								<td>{{d.Product.name}}</td>
								<td class="text-center">{{d.Product.beginning_inventory}}</td>
								<td class="text-center">{{d.delivered !=0 ? d.delivered : '--'}}</td>
								<td class="text-center">{{d.returned !=0 ? d.returned : '--'}}</td>
								<td class="text-center">{{d.sold !=0 ? d.sold : '--'}}</td>
								<td class="text-center">{{d.over_sold !=0 ? d.over_sold : '--'}}</td>
								<td class="text-center">{{d.ending_inventory}}</td>
								<td class="text-center"><input ng-disabled="data.Sale.is_posted == 1" type="number" class="form-control input-sm" ng-init="data.SaleDetail[i].actual_inventory=d.ending_inventory" ng-model="data.SaleDetail[i].actual_inventory" ng-required="true" ng-change="changeActualInventory(i,d)"></input></td>
								<td class="text-center"><input  type="number" class="form-control input-sm" ng-init="SaleDetail[i].missing_qty=0" ng-model="data.SaleDetail[i].missing_qty" ng-required="true" readonly="readonly"></input></td>
							</tr>
							<tr ng-if="!data.SaleDetail.length">
								<td colspan="9">No Data Available</td>
							</tr>
							
						</tbody>
					</table>
				</div>	
			</div>
		</div>
		<div class="panel-footer">
			<div class="text-right" ng-if="data.Sale.is_posted == 1">
				<a href="<?php echo $this->base;?>/admin/sales" class="btn btn-default" type="cancel">Back</a>
				<button class="btn btn-danger" ng-disabled="data.Sale.is_posted">Posted</button>
			</div>
			<div class="text-right" ng-if="data.Sale.is_posted == 0">
				<a href="<?php echo $this->base;?>/admin/sales" class="btn btn-default" type="cancel">Cancel</a>
				<button ng-click="post()" class="btn btn-danger" ng-disabled="!SalesReportForm.$valid || preventDoubleClick">Post</button>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_posting',array('inline'=>false));?>