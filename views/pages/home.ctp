<!--
<a style="cursor:pointer" title="Disabled " data-toggle="tooltip"><image class="circling-balloon" src="<?php echo $this->base;?>/img/gif/circling-balloon.gif"></image></a>
	-->
<?php echo $this->Html->addCrumb('Home Page'); ?>
<style>
	.image_container {
		/*width: 950px;*/
		/*height: 350px;*/
		display: inline-block;
		overflow: hidden;
	}

	.image_container img {
		min-width: 100%;
		min-height: 100%;
		max-width: 100%;
		max-height: 100%;
	}
</style>
<div ng-controller="HomeController" ng-init="initializeController()">
	<div class="row">
		<section class="col-md-9">
			<h4 ng-if="banners.length"></h4>
			<div class="row carousel-holder ng-cloak" ng-if="banners.length">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div id="carousel-example-generic" class="carousel slide box-shadow" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" dir-paginate="(key,data) in banners | itemsPerPage: bannerLimit" ng-class="{active: key==0}"></li>	
						</ol>
						<div class="carousel-inner">
							<div class="item image_container" dir-paginate="(key,data) in banners | itemsPerPage: bannerLimit" ng-class="{active: key==0}">
								<img src="<?php echo $this->base;?>/img/banner/{{data.Banner.img_file}}" alt="{{d.Product.name}}" class="img-responsive">	
							</div>
						</div>
						<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div>
				</div>
			</div>
			<h4>Featured Products</h4>
			<div class="row ng-cloak">
				<div class="col-sm-4 col-lg-4 col-md-4" pagination-id="FeaturedProductList" dir-paginate="d in products | filter:q | itemsPerPage: productLimit">
					<div class="thumbnail box-shadow">
						<div class="row carousel-holder" style="margin-bottom: 0px;" ng-if="d.ProductImage.length">
							<div class="col-md-12">
								<div id="{{d.Product.slug}}" class="carousel slide" data-ride="carousel">
									<ol class="carousel-indicators">
										<li data-target="#carousel-example-generic" data-slide-to="0" dir-paginate="(key,images) in d.ProductImage | filter:q | itemsPerPage: imageLimit" ng-if="d.ProductImage.length > 1" ng-class="{active: key==0}"></li>
									</ol>
									<div class="carousel-inner">
										<div class="item" dir-paginate="(key,images) in d.ProductImage | filter:q | itemsPerPage: imageLimit" ng-class="{active: key==0}">
											<img src="<?php echo $this->base;?>/img/product images/{{images.img_file}}" alt="{{d.Product.name}}" style="height:180px;">
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
						<img src="http://placehold.it/320x150" ng-if="!d.ProductImage.length" style="height:150px;">
						<div class="caption">
							<h4>
								<a href="<?php echo $this->base;?>/product/{{d.Product.slug}}">{{d.Product.name}}</a>
							</h4>
							<p>
							<dl>
							  <dt>Manufactured by:</dt>
							  <dd>{{d.Manufacturer.name}}</dd>
							</dl>
							</p>
						</div>
						<p class="contact-now">
							<a href="<?php echo $this->base;?>/inquiries/send/{{d.Product.slug}}" class="btn btn-success btn-sm"><i class="fa fa-envelope-o"></i> Contact Now</a>
						</p>
					</div>
				</div>
			</div>
		</section>
		<section class="col-md-3 box-shadow">
			<table class="table table-hover categories-table">
				<thead>
					<th>CATEGORIES</th>
				</thead>
				<tbody>
					<tr class="ng-cloak" pagination-id="CategoryList" dir-paginate="d in categories | filter:q | itemsPerPage: categoryLimit">
						<td>
							<a href="<?php echo $this->base;?>/product-category/{{d.Category.slug}}"  >{{d.Category.name}}</a>
						</td>
					</tr>
					<tr><td></td></tr>
				</tbody>
			</table>
			<img class="img img-responsive" src="<?php echo $this->base;?>/img/logo2.png"></img>
		
		</section>
	</div><br/><br/>
</div>
<?php echo $this->Html->script('controllers/home',array('inline'=>false));?>