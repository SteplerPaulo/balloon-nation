<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Products',''); ?>
<div ng-controller="AdminProductsController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-12 col-xs-12">
			<label class="hidden-lg">Search</label>
			<input ng-model="q" class="form-control input-sm" placeholder="Search...">
		</div>
		<div class="col-lg-2 col-md-12 col-xs-12 col-lg-offset-7">
			<label class="hidden-lg">Items per page</label>
			<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
		</div>
	</div><br/>
	<div class="row">
		<div class="hidden-sm hidden-xs col-lg-10">
			<h4 class="ng-cloak">{{customer}}</h4>
		</div>
		<div class="col-lg-2 col-md-12 col-sm-12">
			<a href="<?php echo $this->base;?>/admin/products/add" 
			   class="btn btn-sm btn-success btn-block"><i class="fa fa-plus-circle"></i> New Product
			</a>
		</div>
	</div><br class="hidden-lg"/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-condensed table-striped table-hovered">
				<tbody>
					<tr class="ng-cloak" ng-if="products.length" pagination-id="ProductListTable" dir-paginate="d in products | filter:q | filter:customer | itemsPerPage: pageSize" current-page="currentPage">
						<td>
							<div class="capitalize">{{d.Product.name}}</div>
							<div>
								<small class="text-muted">
									SKU: {{d.Product.item_code}} |
									MOQ: {{d.Product.min}} |
									Price: {{d.Product.selling_price}} |
									Category: {{d.Category.name}}
								</small>
							</div>
						</td>
						<td class="text-right">
							<a href="<?php echo $this->base;?>/admin/products/edit/{{d.Product.slug}}" title="Edit"><i class="fa fa-edit fa-2x"></i></a>
							<a href="<?php echo $this->base;?>/admin/product/{{d.Product.slug}}/images/" title="Images"><i class="fa fa-file-image-o"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="2">
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-show="(products | filter:q | filter:customer).length == 0 && !loading" pagination-id="ProductListTable" >
						<td colspan="2">
							<center><img class="loading" ng-src="<?php echo $this->base;?>/img/no-record-found.png"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" class="text-center" >
							<dir-pagination-controls max-size="7" pagination-id="ProductListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_products',array('inline'=>false));?>
