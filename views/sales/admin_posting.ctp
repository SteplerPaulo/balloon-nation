<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales','/admin/sales'); ?>
<?php echo $this->Html->addCrumb('Inventory Posting'); ?>
<div ng-controller="AdminSalePostingController" ng-init="initializeController()">
	<div class="panel panel-success" ng-form="SalesReportForm">
		<div class="panel-body" id="SalePostingPanel" sale-id="<?php echo $id;?>">
			<div class="row" ng-if="SaleID">
				<div class="col-lg-9">
					<label>Costumer Name:</label>
					{{ Costumer.name}}
				</div>
				<div class="col-lg-3">
					<label>Inclusive Date:</label>
					{{ Sale.from_date |date:'MMMM dd'}} - {{ Sale.to_date |date:'dd, yyyy'}} 
				</div>
			</div>
			<div class="row"  ng-if="!SaleID">
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
				<div class="col-lg-12">
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th rowspan="2">Item Description</th>
								<th rowspan="2" class="text-center w8"><h6>(Current)</h6> Beginning Inventory</th>
								<th rowspan="2" class="text-center w8">Delivered</th>
								<th rowspan="2" class="text-center w8">Returned</th>
								<th rowspan="2" class="text-center w8">Sold</th>
								<th colspan="2" class="text-center w8">Notation</th>
								<th rowspan="2" class="text-center w8"> <h6>(Next Cut Off)</h6>Beginning Inventory</th>
								<th rowspan="2" class="text-center w8">Missing Qty</th>
							</tr>
							<tr>
								<th class="text-center w8"><h6>(Over Sold)</h6>+</th>
								<th class="text-center w8"><h6>(Posible In Stock)</h6>-</th>
							</tr>
						</thead>
						<tbody>	
							<tr ng-repeat="(i,d) in SaleDetail">
								<td>{{d.Product.name}}</td>
								<td class="text-center">{{d.Product.beginning_inventory}}</td>
								<td class="text-center">{{d.delivered}}</td>
								<td class="text-center">{{d.returned}}</td>
								<td class="text-center">{{d.sold}}</td>
								<td class="text-center">{{d.over_sold}} </td>
								<td class="text-center">{{d.in_stock}}</td>
								<td class="text-center"><input ng-disabled="Sale.is_posted == 1" type="number" class="form-control input-sm" ng-init="SaleDetail[i].beginning_inventory=d.in_stock" ng-model="SaleDetail[i].beginning_inventory" ng-required="true"></input></td>
								<td class="text-center"><input ng-disabled="Sale.is_posted == 1" type="number" class="form-control input-sm" ng-init="SaleDetail[i].missing_qty=0" ng-model="SaleDetail[i].missing_qty" ng-required="true"></input></td>
							</tr>
							<tr ng-if="!SaleDetail.length">
								<td colspan="9">No Data Available</td>
							</tr>
							
						</tbody>
					</table>
				</div>	
			</div>
		</div>
		<div class="panel-footer">
			<div class="text-right" ng-if="Sale.is_posted == 1">
				<a href="<?php echo $this->base;?>/admin/sales" class="btn btn-default" type="cancel">Back</a>
				<button class="btn btn-danger" ng-disabled="Sale.is_posted">Posted</button>
			</div>
			<div class="text-right" ng-if="Sale.is_posted == 0">
				<a href="<?php echo $this->base;?>/admin/sales" class="btn btn-default" type="cancel">Cancel</a>
				<button ng-click="post()" class="btn btn-danger" ng-disabled="!SalesReportForm.$valid ">Post</button>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_posting',array('inline'=>false));?>