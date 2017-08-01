<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales'); ?>
<div ng-controller="AdminSalesController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="customer">Customer</label>
			<select class='form-control input-sm' ng-model='customer'>
				<option value="">All</option>
				<option ng-repeat="d in customers">{{d.Customer.name}}</option>
			</select>
		
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-7 col-md-offset-7 col-xs-offset-7">
			<label for="search">Items per page</label>
			<input type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div><br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th colspan="2">MONTHLY SALES REPORTS</th>
						<th colspan="1"><a href="<?php echo $this->base;?>/admin/sales/journal_entry" class="btn btn-sm btn-warning pull-right">Sales Journal Entry</a></th>
					</tr>
					<tr>
						<th>Customer</th>
						<th class="text-center">Date</th>
						<th class="text-center w5">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-if="sales.length" pagination-id="SaleListTable" dir-paginate="d in sales | filter:customer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Customer.name}}</td>
						<td class="text-center">{{d.Sale.from_date | date: "MMMM yyyy"}}</td>
						<td class="actions text-center">
							<a ng-if="d.Sale.is_posted == 0" href="<?php echo $this->base;?>/admin/sales/posting/{{d.Sale.id}}" title="Posting"><i class="fa fa-gavel"></i></a>
							<a ng-if="d.Sale.is_posted == 1" target="_blank" href="<?php echo $this->base;?>/admin/sales/report/{{d.Sale.id}}" title="Print"><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<tr ng-show="(sales | filter:q | filter:customer).length == 0" pagination-id="ProductListTable" >
						<td colspan="4">No Data Found</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" class="text-center">
							<dir-pagination-controls pagination-id="SaleListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_sales',array('inline'=>false));?>
