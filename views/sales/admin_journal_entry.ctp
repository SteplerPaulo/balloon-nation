<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales','/admin/sales'); ?>
<?php echo $this->Html->addCrumb('Journal Entry'); ?>
<div ng-controller="AdminSemiMonthlyReportController" ng-init="initializeController()">	
	<div class="panel panel-success" ng-form="SalesReportForm">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-3">
					<label for="customer">Customer</label>
					<select ng-model="customer" ng-options="d.Customer.name for d in customers" class="form-control input-sm" ng-required="true" ng-change="changeFilter(customer,month_of)">
						<option value="">-- Select --</option>
					</select>
				</div>
				<div class="col-lg-3">
					<label>Month</label>
					<input type="month" ng-model="month_of" class="form-control input-sm" ng-required="true" ng-change="changeFilter(customer,month_of)">
				</div>
				<div class="col-lg-6">
					<label>Import XML Sales Report</label>
					<div class="input-group">
						<input type="file" fileread="vm.uploadme" multiple="multiple" class="form-control input-sm" ng-model="file">
						<span class="input-group-btn">
							<button class="btn btn-primary btn-sm" ng-model="importXML" ng-click="importXML(vm.uploadme)">Import</button>
						</span>
					</div><!--{{vm.uploadme}}-->
				</div>
			</div><br/>
			<div class="row">
				<div class="col-lg-12">
					<label>Imported Document:</label>
					<span ng-if="!vm.uploadme.length">N.A</span>
					<span style="margin-right:5px;" ng-repeat="doc in fileData">
						<a ng-class="(customer.Customer.compcode == doc.StoreNo)?'label label-success':'label label-danger'">
							# {{doc.DocNo}} {{doc.StoreName}}
						</a>
					</span>
					<div ng-if="hasProblem" class="alert alert-warning">
						Problem on imported files found. Please import files related to the selected customer only
					</div>
				</div>
			</div>
			<div class="row" ng-if="is_posted == false">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table class="table table-bordered table-condensed" >
						<thead>
							<tr>
								<th colspan="7">
									<div class="btn-group pull-right">
										<button type="button" ng-class="(view_all_items?'active':'')" class="btn btn-sm btn-default" ng-model="view_all_items" ng-click="btnGrp(true,false)">View All Items</button>
										<button type="button" ng-class="(selected_item_only?'active':'')"class="btn btn-sm btn-default" ng-model="selected_item_only" ng-click="btnGrp(false,true)">Selected Item ({{selected_item_count}})</button>
									</div>
								</td>
								<td colspan="2">
									<input ng-model="item_code" ng-change="checkItem(item_code)" placeholder="Item Code" class="form-control input-sm"></input>
								</td>
							</tr>
							<tr>
								<th rowspan="2" class="text-center w5">
									<input type="checkbox" ng-model="check_all" ng-change="checkAll(check_all)">
								</th>
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
							<tr ng-hide="data[i].is_readonly && selected_item_only" ng-if="data.length" ng-repeat="(i,d) in data">
								<td class="text-center"><input type="checkbox" ng-model="data[i].checkbox" ng-change="check(i,data[i].checkbox)"></td>	
								<td class="capitalize">{{d.Product.name}} <sup>SKU - {{d.Product.item_code}}</sup></td>
								<td class="text-center">{{d.Product.beginning_inventory}}</td>
								<td class="text-center">{{d.delivered}}</td>
								<td class="text-center">{{d.returned}}</td>
								<td class="text-center">{{d.total_inventory}}</td>
								<td class="text-center">
									<input ng-required="!data[i].is_readonly && selected_item_only" ng-disabled="data[i].is_readonly" type="number" class="form-control input-sm" ng-model="data[i].sold" ng-change="changeSold(i,d)"></input>
								</td>
								<td class="text-center">
									<div ng-model="data[i].ending_inventory" >{{data[i].ending_inventory}}</div>
								</td>
								<td class="text-center">
									<div>{{d.over_sold}}</div>
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
				<button ng-click="save()" class="btn btn-danger" ng-disabled="!SalesReportForm.$valid || hasProblem || !selected_item_count || preventDoubleClick" ng-if="is_posted == false">Save</button>
			</div>
		</div>
	</div>
</div>	

<?php echo $this->Html->script('controllers/admin_journal_entry',array('inline'=>false));?>
