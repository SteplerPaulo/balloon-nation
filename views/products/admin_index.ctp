<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products',''); ?>
<div ng-controller="AdminProductsController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<label for="customer">Customer</label>
			<select class='form-control input-sm ng-cloak' ng-model='customer' ng-change="changeCustomer()">
				<option ng-repeat="d in customers">{{d.Customer.name}}</option>
			</select>
		</div>
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="search">Search</label>
			<input ng-model="q" class="form-control input-sm" placeholder="Enter text">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-3 col-md-offset-3 col-xs-offset-3">
			<label for="search">Items per page</label>
			<input type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-condensed table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="5">PRODUCTS</th>
						<th colspan="1"><a href="<?php echo $this->base;?>/admin/products/add" class="btn btn-sm btn-success pull-right">New Product</a></th>
					</tr>
					<tr>
						<th>SKU</th>
						<th>Description</th>
						<th>Category</th>
						<th class="text-center">Min</th>
						<th class="text-center">Selling Price</th>
						<th class="actions text-center">Action</th>
					</tr>
					<tr>
					</tr>
				</thead>
				<tbody>
					<tr class="ng-cloak" ng-if="products.length" pagination-id="ProductListTable" dir-paginate="d in products | filter:q | filter:customer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Product.item_code}}</td>
						<td class="capitalize">{{d.Product.name}}</td>
						<td>{{d.Category.name}}</td>
						<td class="text-center" ng-if="customer == ''">{{d.Customer.name}}</td>
						<td class="text-center">{{d.Product.min}}</td>
						<td class="text-center">{{d.Product.selling_price}}</td>
						<td class="actions text-center">
							<a href="<?php echo $this->base;?>/admin/products/edit/{{d.Product.slug}}" title="Edit"><i class="fa fa-edit"></i></a>
							| 
							<a href="<?php echo $this->base;?>/admin/product/{{d.Product.slug}}/images/" title="Images"><i class="fa fa-file-image-o"></i></a>
							|
							<a href="<?php echo $this->base;?>/admin/products/delete/{{d.Product.id}}" onclick="return confirm('Are you sure you want to delete this product?');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
						
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="6">
							<center>
								<img class="loading"src="/balloon-nation/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-show="(products | filter:q | filter:customer).length == 0 && !loading" pagination-id="ProductListTable" >
						<td colspan="6">
							<center><img class="loading" src="{{src}}"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="text-center" >
							<dir-pagination-controls pagination-id="ProductListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_products',array('inline'=>false));?>
