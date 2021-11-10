<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Products'); ?>
<div ng-controller="ProductsController" ng-init="initializeController()" >	
	<div class="row">
		<section class="col-xs-12 col-lg-9 col-lg-push-3">
			<div class="row">
				<div class="col-lg-7 col-md-12 col-xs-12">
					<div class="input-group">
						<span class="input-group-addon box-shadow"><i class="fa fa-search"></i></span>
						<input ng-model="productFilter" id="search" class="box-shadow form-control input-sm" placeholder="Search item">
					</div>
				</div>
			</div><br/>
			<div class="row ng-cloak" directive-when-scrolled="loadMore()">
				<div class="col-sm-4 col-lg-4 col-md-4" ng-repeat="d in (filteredProducts = (products | filter: productFilter )) | limitTo: limit">
					<div class="thumbnail box-shadow">
						<div class="row carousel-holder" style="margin-bottom: 0px;" ng-if="d.ProductImage.length">
							<div class="col-md-12">
								<div id="{{d.Product.slug}}" class="carousel slide" data-ride="carousel">
									<ol class="carousel-indicators">
										<li data-target="#carousel-example-generic" data-slide-to="0" dir-paginate="(key,images) in d.ProductImage | filter:q | itemsPerPage: productLimit" ng-if="d.ProductImage.length > 1" ng-class="{active: key==0}"></li>
									</ol>
									<div class="carousel-inner">
										<div class="item" dir-paginate="(key,images) in d.ProductImage | filter:q | itemsPerPage: productLimit" ng-class="{active: key==0}">
											<img ng-src="<?php echo $this->base;?>/img/product images/{{images.img_file}}" alt="{{d.Product.name}}" style="height:150px;">
										</div>
									</div>
									<a class="left carousel-control" href="#{{d.Product.slug}}" data-slide="prev" ng-if="d.ProductImage.length > 1" >
										<span class="glyphicon glyphicon-chevron-left" style="font-size: 15px;"></span>
									</a>
									<a class="right carousel-control" href="#{{d.Product.slug}}" data-slide="next" ng-if="d.ProductImage.length > 1" >
										<span class="glyphicon glyphicon-chevron-right" style="font-size: 15px;"></span>
									</a>
								</div>
							</div>
						</div>
						<img ng-src="<?php echo $this->base;?>/img/lazyload.jpg" ng-if="!d.ProductImage.length">
						
						<div class="caption">
							<h4>
								<a href="<?php echo $this->base;?>/product/{{d.Product.slug}}">{{d.Product.name}}</a>
							</h4>
							<dl>
							  <dt>Manufactured by:</dt>
							  <dd>{{d.Manufacturer.name}}</dd>
							</dl>
						</div>
						<p class="contact-now">
							<a href="<?php echo $this->base;?>/inquiries/send/{{d.Product.slug}}" class="btn btn-success btn-sm"><i class="fa fa-envelope-o"></i> Contact Now</a>
						</p>
					</div>
				</div>
				<div class="col-sm-12 col-lg-12 col-md-12" ng-if="filteredProducts.length == 0">
					<div class="alert alert-danger box-shadow">No results found...</div>
				</div>
				<div class="col-sm-12 col-lg-12 col-md-12" ng-if="endResult">
					<center>**End Result**</center>
				</div>
				<div class="col-lg-12 ng-cloak text-center" >
					<button ng-show="showLoadBtn" class="btn btn-default" ng-click="loadMore()">
						Load More...
					</button>
				</div>
			</div>
		</section>
		<section class="col-xs-12 col-lg-3 col-lg-pull-9 categories-section">
			<table class="table table-hover categories-table">
				<thead>
					<th><a href="<?php echo $this->base;?>/products">CATEGORIES</a></th>
				</thead>
				<tbody>
					<tr class="ng-cloak" pagination-id="CategoryList" dir-paginate="d in categories | filter:q | itemsPerPage: categoryLimit">
						<td>
							<a href="<?php echo $this->base;?>/product-category/{{d.Category.slug}}"  >{{d.Category.name}}</a>
						</td>
					</tr>
				</tbody>
			</table>
		</section>
		
	</div>
</div>

		
<?php echo $this->Html->script('controllers/products',array('inline'=>false));?>
