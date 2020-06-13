<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Deliveries',''); ?>
<div ng-controller="AdminDeliveriesController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-xs-3">
			<label for="customer">Customer</label>
			<select class='form-control' ng-model='customer'>
				<option value="">All</option>
				<option ng-repeat="d in customers">{{d.Customer.name}}</option>
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
						<th colspan="4">DELIVERIES</th>
						<th colspan="1"><a href="<?php echo $this->base;?>/admin/deliveries/create" class="btn btn-sm btn-warning pull-right">Create Delivery</a></th>
					</tr>
					<tr>
						<th>Delivery Receipt No.</th>
						<th class="">Customer</th>
						<th class="text-center">Stock Clerk</th>
						<th class="text-center">Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr pagination-id="DeliveriesListTable" dir-paginate="d in deliveries | filter:q | filter:customer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Delivery.delivery_receipt_no}}</td>
						<td class="">{{d.Customer.name}}</td>
						<td class="text-center">{{d.Delivery.stock_clerk}}</td>
						<td class="text-center">{{d.Delivery.formated_date}}</td>
						<td class="text-center">
							<a href="<?php echo $this->base;?>/admin/deliveries/report/{{d.Delivery.id}}" title="Print" target="_blank"><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="5">
							<center>
								<img class="loading"src="/balloon-nation/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-show="(deliveries | filter:q | filter:customer).length == 0" pagination-id="DeliveriesListTable" >
						<td colspan="5">
							<center><img class="loading" src="{{src}}"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" class="text-center">
							<dir-pagination-controls pagination-id="DeliveriesListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_deliveries',array('inline'=>false));?>