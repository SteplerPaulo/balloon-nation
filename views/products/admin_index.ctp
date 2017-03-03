<style>
	i{cursor:pointer}
</style>
<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products',''); ?>
<div ng-controller="AdminProductsController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="costumer">Costumer</label>
			<select class='form-control' ng-model='costumer'>
				<option value="">All</option>
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
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="6">PRODUCTS</th>
						<th colspan="1">
							<div class="btn-group pull-right" role="group" >
							  <a href="<?php echo $this->base;?>/admin/products/add" title="Add New Product" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
							</div>
						</th>
					</tr>
					<tr>
						<th>Item Code</th>
						<th>Description</th>
						<th>Category</th>
						<th class="hide">Costumer</th>
						<th class="text-center">Min</th>
						<th class="text-center">Current Qty</th>
						<th class="text-center">Selling Price</th>
						<th class="actions text-center">Action</th>
					</tr>
					<tr>
					</tr>
				</thead>
				<tbody>
					<tr ng-if="products.length" pagination-id="ProductListTable" dir-paginate="d in products | filter:q | filter:costumer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Product.item_code}}</td>
						<td>{{d.Product.name}}</td>
						<td>{{d.Category.name}}</td>
						<td class="hide">{{d.Costumer.name}}</td>
						<td class="text-center">{{d.Product.min}}</td>
						<td class="text-center">{{d.Product.current_quantity}}</td>
						<td class="text-center">{{d.ProductPricing[0].selling_price}}</td>
						<td class="actions text-center">
							<a ng-click="openTransaction(d,'lg')" title="Transactions"><i class="fa fa-truck"></i></a>
							|
							<a  ng-click="openPricing(d,'sm')" title="Change price"><i class="fa fa-money"></i></a>
							| 
							<a href="<?php echo $this->base;?>/admin/products/edit/{{d.Product.slug}}" title="Edit"><i class="fa fa-edit"></i></a>
							| 
							<a href="<?php echo $this->base;?>/admin/product/{{d.Product.slug}}/images/" title="Images"><i class="fa fa-file-image-o"></i></a>
							|
							<a href="<?php echo $this->base;?>/admin/products/delete/{{d.Product.id}}" onclick="return confirm('Are you sure you want to delete this product?');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
						
						</td>
					</tr>
					<tr ng-show="(products | filter:q | filter:costumer).length == 0" pagination-id="ProductListTable" >
						<td colspan="7">No Data Found</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" class="text-center">
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
				<div class="col-lg-6">
					<table class="table table-condensed table-striped table-hovered">
						<tr>
							<th>Item Description :</th>
							<td>{{$ctrl.data.Product.name}}</td>
						</tr>
						<tr>
							<th>Costumer Name (Branch):</th>
							<td>{{$ctrl.data.Costumer.name}}</td>
						</tr>
						<tr>
							<th>Last Date Posted : </th>
							<td>{{$ctrl.data.Product.formated_last_date_posted | date:"MMM. dd, y"}}</td>
						</tr>
					</table>
				</div>
				<div class="col-lg-4 col-lg-offset-2">
					<table class="table table-condensed table-striped table-hovered">
						<tr>
							<th>Selling Price : </th>
							<td>{{$ctrl.selling_price}}</td>
						</tr>
						<tr>
							<th>Minimun Quantity:</th>
							<td>{{$ctrl.data.Product.min}}</td>
						</tr>
						<tr>
							<th>Current Quantity:</th>
							<td>{{$ctrl.CurrentQuantity}}</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-condensed">
						<thead>	
							<tr>
								<th colspan="8" class="alert alert-success">TRANSACTIONS RECORD</th>
							</tr>
							<tr>
								<th>Stock Clerk</th>
								<th class="text-center"><h6>(In Stock)</h6>Counted Qty</th>
								<th class="text-center"><h6>(Bad Items)</h6>Returned Qty </th>
								<th class="text-center">Delivered Qty</th>
								<th class="text-center">DR No.</th>
								<th class="text-center">Date</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="(key, tr) in $ctrl.transactions.Data">
								<td>{{tr.ProductTransaction.name}}</td>
								<td class="text-center">{{tr.ProductTransaction.counted_qty}}</td>
								<td class="text-center">{{tr.ProductTransaction.returned_qty}}</td>
								<td class="text-center">{{tr.ProductTransaction.delivered_qty}}</td>
								<td class="text-center">{{tr.ProductTransaction.dr_no}}</td>
								<td class="text-center">{{tr.ProductTransaction.formated_date}}</td>
							</tr>
							<tr ng-if="!$ctrl.transactions.Data.length">	
								<th colspan="8" class="text-center">No Transaction<hr></th>
							</tr>
							<tr ng-if="$ctrl.transactions.Data.length">
								<th></th>
								<th class="text-center"></th>
								<th class="text-center">{{$ctrl.TotalReturnedQty}}</th>
								<th class="text-center">{{$ctrl.TotalDeliveredQty}}</th>
								<th class="text-center"></th>
								<td></td>
								<td></td>
							</tr>
							
							<tr>	
								<th colspan="8" class="alert alert-success">ADD NEW TRANSACTION</th>
							</tr>
							<tr ng-form="$ctrl.TransactionForm">
								<td><input ng-model="$ctrl.name" ng-required="true" class="form-control input-sm" placeholder="S. Clerk"></input></td>
								<td><input min="0" type="number" ng-change="$ctrl.toggleQty($ctrl.counted_qty,$ctrl.returned_qty,$ctrl.delivered_qty)" ng-model="$ctrl.counted_qty" ng-required="true" class="form-control input-sm" placeholder="Counted"></input></td>
								<td><input min="0" type="number" ng-change="$ctrl.toggleQty($ctrl.counted_qty,$ctrl.returned_qty,$ctrl.delivered_qty)" ng-model="$ctrl.returned_qty" ng-required="true" class="form-control input-sm" placeholder="Returns"></input></td>
								<td><input min="0" type="number" ng-change="$ctrl.toggleQty($ctrl.counted_qty,$ctrl.returned_qty,$ctrl.delivered_qty)" ng-model="$ctrl.delivered_qty" ng-required="true" class="form-control input-sm" placeholder="Deliver"></input></td>
								<td><input ng-model="$ctrl.dr_no" class="form-control input-sm" ng-required="true" placeholder="DR No."></input></td>
								<td><input type="datetime-local" ng-model="$ctrl.dateNow" class="form-control input-sm" ></input></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
        <div class="modal-footer">
			<button id="SaveButton" class="btn btn-primary" ng-click="$ctrl.save()" ng-disabled="!$ctrl.TransactionForm.$valid">Save</button>
			<button class="btn btn-warning" ng-click="$ctrl.close()">Close</button>
        </div>
    </script>
	
	
	
	<script type="text/ng-template" id="PricingModal.html">
		<div></div>
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{$ctrl.data.Product.name}}</h3>
        </div>
        <div class="modal-body" id="modal-body">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Purchase Price</th>
						<th>Selling Price</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-form="$ctrl.PricingForm">
						<td>
							<input ng-model="$ctrl.purchase_price" min="0" type="number" class="form-control" ng-required="true"></input>
						</td>
						<td>
							<input ng-model="$ctrl.selling_price" min="0" type="number" class="form-control" ng-required="true"></input>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
        <div class="modal-footer">
			<button class="btn btn-primary" ng-click="$ctrl.save()" ng-disabled="!$ctrl.PricingForm.$valid">Save</button>
			<button class="btn btn-warning" ng-click="$ctrl.close()">Close</button>
        </div>
    </script>
		
</div>
<?php echo $this->Html->script('controllers/admin_products',array('inline'=>false));?>
