<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales'); ?>
<div ng-controller="AdminSalesController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="costumer">Costumer</label>
			<select class='form-control input-sm' ng-model='costumer'>
				<option value="">All</option>
				<option ng-repeat="d in costumers">{{d.Costumer.name}}</option>
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
						<th colspan="3">CUT-OFF SALES REPORTS</th>
						<th colspan="1"><a href="<?php echo $this->base;?>/admin/sales/balancing" class="btn btn-sm btn-warning pull-right">Semi-monthly Balancing</a></th>
					</tr>
					<tr>
						<th rowspan="2">Cotumer Name</th>
						<th colspan="2" class="text-center">Inclusive Date</th>
						<th rowspan="2" class="text-center w5">Action</th>
					</tr>
					<tr>
						<th class="text-center">From</th>
						<th class="text-center">To</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-if="sales.length" pagination-id="SaleListTable" dir-paginate="d in sales | filter:costumer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Costumer.name}}</td>
						<td class="text-center">{{d.Sale.from_date}}</td>
						<td class="text-center">{{d.Sale.to_date}}</td>
						<td class="actions text-center">
							<a target="_blank" href="<?php echo $this->base;?>/admin/sales/posting/{{d.Sale.id}}" title="Posting"><i class="fa fa-gavel"></i></a>
							| 
							<a target="_blank" href="<?php echo $this->base;?>/admin/sales/report/{{d.Sale.id}}" title="Print"><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<tr ng-show="(sales | filter:q | filter:costumer).length == 0" pagination-id="ProductListTable" >
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
