<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products','/admin/products/'); ?>
<?php echo $this->Html->addCrumb('Sales'); ?>
<div ng-controller="AdminProductsController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="costumer">Costumer</label>
			<select class='form-control input-sm' ng-model='costumer'>
				<option ng-repeat="d in costumers">{{d.Costumer.name}}</option>
			</select>
		
		</div>
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="search">Search</label>
			<input ng-model="q" class="form-control input-sm" placeholder="Filter text">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-4 col-md-offset-4 col-xs-offset-4">
			<label for="search">Items per page</label>
			<input type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div><br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th colspan="9">REPORT</th>
					</tr>
					<tr>
						<th rowspan="2">Description</th>
						<th colspan="3" class="text-center">Quantity</th>
						<th colspan="2" class="text-center">Sale</th>
						<th rowspan="2" class="text-center w10">Missing Quantity</th>
						<th rowspan="2" class="actions text-center">Action</th>
					</tr>
					<tr>
						
						<th rowspan="2" class="hide">Costumer</th>
						<th class="text-center w10">Delivered</th>
						<th class="text-center w10">Returned</th>
						<th class="text-center w10">Current</th>
						<th class="text-center w10">System Count</th>
						<th class="text-center w10">Actual</th>
					</tr>
					<tr>
					</tr>
				</thead>
				<tbody>
					<tr ng-if="products.length" pagination-id="ProductListTable" dir-paginate="d in products | filter:q | filter:costumer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Product.name}}</td>
						<td class="hide">{{d.Costumer.name}}</td>
						<td class="text-center">
							<div ng-if="d.Product.delivered">{{d.Product.delivered}}</div>
							<div ng-if="!d.Product.delivered">0</div>
						</td>
						<td class="text-center">
							<div ng-if="d.Product.returned">{{d.Product.returned}}</div>
							<div ng-if="!d.Product.returned">0</div>	
						</td>
						<td class="text-center">
							{{d.Product.current_quantity}}
						</td>
						<td class="text-center">
							{{d.Product.sales}}
						</td>
						<td class="text-center">
							<input type="number" class="form-control input-sm"></input>
						</td>
						<td class="text-center">
						</td>
						<td class="actions text-center">
						</td>
					</tr>
					<tr ng-show="(products | filter:q | filter:costumer).length == 0" pagination-id="ProductListTable" >
						<td colspan="9">No Data Found</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9" class="text-center">
							<dir-pagination-controls pagination-id="ProductListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_sales',array('inline'=>false));?>
