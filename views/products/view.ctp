<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Products','/products'); ?>
<?php echo $this->Html->addCrumb('Details'); ?>
<div ng-controller="ViewProductController" ng-init="initializeController()">	
	<h2>{{data.Product.name}}</h2>
	<div class="row">
		<div class="col-lg-8">
			<div class="thumbnail">
				<div class="row carousel-holder" style="margin-bottom: 0px;" ng-if="data.ProductImage.length">
					<div class="col-md-12">
						<div id="{{data.Product.slug}}" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0" dir-paginate="(key,images) in data.ProductImage | filter:q | itemsPerPage: imageLimit" ng-if="data.ProductImage.length > 1" ng-class="{active: key==0}"></li>
							</ol>
							<div class="carousel-inner">
								<div class="item" dir-paginate="(key,images) in data.ProductImage | filter:q | itemsPerPage: imageLimit" ng-class="{active: key==0}">
									<img src="<?php echo $this->base;?>/img/product images/{{images.img_file}}" alt="{{data.Product.name}}">
								</div>
							</div>
							<a class="left carousel-control" href="#{{data.Product.slug}}" data-slide="prev" ng-if="data.ProductImage.length > 1" >
								<span class="glyphicon glyphicon-chevron-left" style="font-size: 15px;"></span>
							</a>
							<a class="right carousel-control" href="#{{data.Product.slug}}" data-slide="next" ng-if="data.ProductImage.length > 1" >
								<span class="glyphicon glyphicon-chevron-right" style="font-size: 15px;"></span>
							</a>
						</div>
					</div>
				</div>
				<img src="http://placehold.it/320x150" ng-if="!data.ProductImage.length">
			</div>
		</div>
		<div class="col-lg-4">
			<strong>{{data.Product.name}}</strong><br/><br/>
			
			<a href="<?php echo $this->base;?>/inquiries/send/{{data.Product.slug}}" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-envelope-o"></i> Contact Now</a>
			<br/><br/>
			<p ng-bind-html="data.Product.description"></p>
			<br/><br/>
			<div class="caption">
				<dl>
				  <dt>Category:</dt>
				  <dd>{{data.Category.name}}</dd>
				</dl>
			</div>
		</div>
	</div>
</div>

<?php echo $this->Html->script('controllers/product_view',array('inline'=>false));?>

