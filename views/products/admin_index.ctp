<style>
	i{
		cursor:pointer;
	}
</style>
<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products',''); ?>
<div ng-controller="AdminProductsController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<label for="search">Search</label>
			<input ng-model="q" id="search" class="form-control input-sm" placeholder="Filter text">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-6 col-md-offset-6 col-xs-offset-6">
			<label for="search">Items per page</label>
			<input type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div><br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="8">PRODUCTS</th>
						<th colspan="1"><a href = "<?php echo $this->base;?>/admin/products/add" class="btn btn-sm btn-warning pull-right">Add New Product</a></th>
					</tr>
					<tr>
						<th>Item Code</th>
						<th>Description</th>
						<th>Category</th>
						<th>Costumer</th>
						<th class="text-center">Posted Qty</th>
						<th class="text-center">Current Qty</th>
						<th class="text-center">Min</th>
						<th class="text-center">Last Date Posted</th>
						<th class="actions text-center">Action</th>
					</tr>
					<tr>
					</tr>
				</thead>
				<tbody>
					<tr pagination-id="ProductListTable" dir-paginate="d in products | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Product.item_code}}</td>
						<td>{{d.Product.name}}</td>
						<td>{{d.Category.name}}</td>
						<td>{{d.Costumer.name}}</td>
						<td class="text-center">{{d.Product.posted_quantity}}</td>
						<td class="text-center">{{d.Product.current_quantity}}</td>
						<td class="text-center">{{d.Product.min}}</td>
						<td class="text-center">{{d.Product.formated_last_date_posted}}</td>
						<td class="actions text-center">
							<a ng-click="open(d,'lg')" data-toggle="tooltip" title="Product Transactions"><i class="fa fa-truck"></i></a>
							| 
							<a href="<?php echo $this->base;?>/admin/products/edit/{{d.Product.slug}}" data-toggle="tooltip" title="Edit Product Details"><i class="fa fa-edit"></i></a>
							| 
							<a href="<?php echo $this->base;?>/admin/product/{{d.Product.slug}}/images/" data-toggle="tooltip" title="Product Images"><i class="fa fa-file-image-o"></i></a>
							|
							<a href="<?php echo $this->base;?>/admin/products/delete/{{d.Product.id}}" onclick="return confirm('Are you sure you want to delete this product?');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
						
						</td>
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
	
	<script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Product Transactions</h3>
        </div>
        <div class="modal-body" id="modal-body">
			<div class="row">
				<div class="col-lg-5">
					<table class="table table-condensed table-striped table-hovered">
						<tr>
							<th>Item Description :</th>
							<td>{{$ctrl.data.Product.name}}</td>
						</tr>
						<tr>
							<th>Last Date Posted : </th>
							<td>{{$ctrl.data.Product.formated_last_date_posted | date:"MMM. dd, y"}}</td>
						</tr>
					</table>
				</div>
				<div class="col-lg-5 col-lg-offset-1">
					<table class="table table-condensed table-striped table-hovered">
						<tr>
							<th>Costumer Name (Branch):</th>
							<td>{{$ctrl.data.Costumer.name}}</td>
						</tr>
						<tr>
							<th>Posted Quantity:</th>
							<td>{{$ctrl.data.Product.posted_quantity}}</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-condensed table-bordered">
						<thead>	
							<tr>
								<th colspan="8" class="alert alert-success">TRANSACTIONS RECORD</th>
							</tr>
							<tr>
								<th>Replenisher's Name</th>
								<th class="text-center">Counted Qty</th>
								<th class="text-center">Returns Qty</th>
								<th class="text-center">Replenish Qty</th>
								<th class="text-center">Sold <h6>( per sale report)</h6></th>
								<th class="text-center">Date</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="(key, tr) in $ctrl.transactions.Data">
								<td>{{tr.ProductTransaction.name}}</td>
								<td class="text-center">{{tr.ProductTransaction.added}}</td>
								<td class="text-center">{{tr.ProductTransaction.subtracted}}</td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center">{{tr.ProductTransaction.formated_date}}</td>
							</tr>
							<tr ng-if="!$ctrl.transactions.Data.length">	
								<th colspan="8" class="alert alert-warning text-center">No Data Available</th>
							</tr>
							</tr>
								<th rowspan="3">TOTAL:</th>
								<th rowspan="3" class="text-center">0</th>
								<th rowspan="3" class="text-center">0</th>
								<th rowspan="3" class="text-center">{{$ctrl.TotalAdded}}</th>
								<th rowspan="3" class="text-center">{{$ctrl.TotalSubtracted}}</th>
								<td><h4>Current Quantity:<b> {{$ctrl.CurrentQuantity}}</b></h4></td>
							</tr>
							<tr>	
								<td>Minimun Quantity:<b>{{$ctrl.data.Product.min}}</b></td>
							</tr>
							<tr>	
								<td>Missing Quantity:<b></b></td>
							</tr>
							<tr>	
								<th colspan="8" class="alert alert-success">ADD NEW TRANSACTION</th>
							</tr>
							<tr ng-form="$ctrl.TransactionForm">
								<td><input ng-model="$ctrl.name" ng-required="true" class="form-control input-sm" placeholder="Replenisher"></input></td>
								<td><input min="0" type="number" ng-required="true" class="form-control input-sm" placeholder="Counted"></input></td>
								<td><input min="0" type="number" ng-required="true" class="form-control input-sm" placeholder="Returns"></input></td>
								
								<td><input min="0" type="number" ng-change="$ctrl.toggleQty($ctrl.added,$ctrl.subtracted)" ng-model="$ctrl.added" ng-required="true" class="form-control input-sm" placeholder="Replenish"></input></td>
								<td><input min="0" type="number" ng-change="$ctrl.toggleQty($ctrl.added,$ctrl.subtracted)" ng-model="$ctrl.subtracted" ng-required="true" class="form-control input-sm" placeholder="Sold"></input></td>
								<td><input type="datetime-local" ng-model="$ctrl.dateNow" class="form-control input-sm" ></input></td>
							</tr>
							
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">	
					<i ng-if="!$ctrl.formula" ng-click="$ctrl.toggleFormula('on')" class="fa fa-toggle-off" data-toggle="tooltip" title="Show CURRENT QUANTITY Formula"></i>
					<i ng-if="$ctrl.formula" ng-click="$ctrl.toggleFormula('off')" class="fa fa-toggle-on" data-toggle="tooltip" title="Hide CURRENT QUANTITY Formula"></i>
					<h6 ng-if="$ctrl.formula" class="label label-info" style="color:darkred">CURRENT QUANTITY = Posted Quantity + Total Added Quantity - Total Subtracted Quantity</h6>
				</div>
			</div>
		</div>
        <div class="modal-footer">
			<button id="SaveButton" class="btn btn-primary" ng-click="$ctrl.save()" ng-disabled="!$ctrl.TransactionForm.$valid">Save</button>
			<button class="btn btn-warning" ng-click="$ctrl.close()">Close</button>
        </div>
    </script>
</div>
<?php echo $this->Html->script('controllers/admin_products',array('inline'=>false));?>