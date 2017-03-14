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
						<th colspan="2">SALE REPORTS</th>
						<th colspan="1"><a href="<?php echo $this->base;?>/admin/sales/create" class="btn btn-sm btn-warning pull-right">Create Semi-Monthly Sale Report</a></th>
					
					</tr>
					<tr>
						<th>Cotumer Name</th>
						<th class="text-center">Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-if="sales.length" pagination-id="SaleListTable" dir-paginate="d in sales | filter:costumer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Costumer.name}}</td>
						<td class="text-center">{{d.Sale.date}}</td>
						<td class="actions text-center">
							<a target="_blank" href="<?php echo $this->base;?>/admin/sales/report" title="Print"><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<tr ng-show="(sales | filter:q | filter:costumer).length == 0" pagination-id="ProductListTable" >
						<td colspan="3">No Data Found</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" class="text-center">
							<dir-pagination-controls pagination-id="SaleListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_sales',array('inline'=>false));?>
