<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Deliveries',''); ?>
<div ng-controller="AdminDeliveriesController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-12 col-xs-12">
			<label for="customer">Filter by Customer</label>
			<select class='form-control ng-cloak input-sm' ng-model='customer'>
				<option value="">All</option>
				<option ng-repeat="d in customers">{{d.Customer.name}}</option>
			</select>
		</div>
		<div class="col-lg-3 col-md-12 col-xs-12">
			<label for="search">Search</label>
			<input ng-model="q" class="form-control input-sm" placeholder="Filter text">
		</div>
		<div class="col-lg-2 col-md-12 col-xs-12 col-lg-offset-3">
			<label for="search">Items per page</label>
			<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
		</div>
	</div><br/>
	<div class="row">
		<div class="col-lg-2 col-lg-offset-10 col-md-12 col-sm-12">
			<a href="<?php echo $this->base;?>/admin/deliveries/create" 
			   class="btn btn-sm btn-warning btn-block"><i class="fa fa-plus-circle"></i> Create Delivery
			</a>
		</div>
	</div><br/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-responsive table-striped table-hovered">
				<tbody>
					<tr class="ng-cloak" pagination-id="DeliveriesListTable" dir-paginate="d in deliveries | filter:q | filter:customer | itemsPerPage: pageSize" current-page="currentPage">
						<td> 
							{{d.Customer.name}}<br/>
								<small class="text-muted">
									<a title="Date">{{d.Delivery.formated_date}}</a> | 
									<a title="Clerk">{{d.Delivery.stock_clerk}}</a> |
									<a title="Receipt No.">{{d.Delivery.delivery_receipt_no}}</a>
								</small>
							</div>
						</td>
						<td class="text-center">
							<a href="<?php echo $this->base;?>/admin/deliveries/report/{{d.Delivery.id}}" title="Print" target="_blank"><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td>
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-show="(deliveries | filter:q | filter:customer).length == 0" pagination-id="DeliveriesListTable" >
						<td>
							<center><img class="loading" ng-src="{{src}}"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-center">
							<dir-pagination-controls pagination-id="DeliveriesListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_deliveries',array('inline'=>false));?>