<div ng-controller="DashboardController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-12 col-xs-12">
			<label class="hidden-lg">Search</label>
			<input ng-model="q" class="form-control input-sm" placeholder="Search...">
		</div>
		<div class="col-lg-2 col-lg-offset-7 col-md-12 col-sm-12">
			<a href="<?php echo $this->base;?>/admin/customers/add" 
			   class="btn btn-sm btn-warning btn-block"><i class="fa fa-plus-circle"></i> New Customer
			</a>
		</div>
	</div>
	<h3 class="ng-cloak">OUR CUSTOMERS</h3>
	<div class="row">
		<div class="col-lg-2"  ng-repeat="d in customers | filter:q">
			<div class="thumbnail  ng-cloak" style="height:19em">
				<img ng-if="!d.Customer.logo" ng-src="<?php echo $this->base;?>/img/customers/nologo.jpg" alt="...">
				<img ng-if="d.Customer.logo" ng-src="<?php echo $this->base;?>/img/customers/{{d.Customer.logo}}" alt="...">
				<div class="">
					{{d.Customer.name}} 
					<a data-toggle="tooltip" title="{{d.Customer.address}}"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>
				</div>
				
				<div class="btn-bottom-wrapper">
				
					<a href="<?php echo $this->base;?>/admin/products/index/?{{d.Customer.id}}&{{d.Customer.name}}">Products</a>
					<br/>
					<a href="<?php echo $this->base;?>/admin/sales/index/?{{d.Customer.id}}&{{d.Customer.name}}">Sales</a> 
					<a href="<?php echo $this->base;?>/admin/deliveries/index/?{{d.Customer.id}}&{{d.Customer.name}}">Deliveries</a>
					<br/>
					<a href="<?php echo $this->base;?>/admin/customers/edit/{{d.Customer.slug}}">Edit</a> 
					<a href="<?php echo $this->base;?>/admin/customers/clone/{{d.Customer.slug}}">Clone</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row" ng-show="loading">
		<div class="col-lg-12">
			<center>
				<img class="loading"src="<?php echo $this->base;?>/img/loading.gif"/>
			</center>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_dashboard',array('inline'=>false));?>