<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Deliveries',''); ?>
<div ng-controller="AdminDeliveriesController" ng-init="initializeController()">	
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
						<th colspan="4">DELIVERIES</th>
						<th colspan="1"><a href="<?php echo $this->base;?>/admin/deliveries/create" class="btn btn-sm btn-warning pull-right">Create Delivery</a></th>
					</tr>
					<tr>
						<th>Delivery Receipt No.</th>
						<th class="text-center">Costumer</th>
						<th class="text-center">Stock Clerk</th>
						<th class="text-center">Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr pagination-id="ProductListTable" dir-paginate="d in deliveries | filter:q | filter:costumer | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Delivery.delivery_receipt_no}}</td>
						<td class="text-center">{{d.Costumer.name}}</td>
						<td class="text-center">{{d.Delivery.stock_clerk}}</td>
						<td class="text-center">{{d.Delivery.formated_date}}</td>
						<td class="text-center"></td>
					</tr>
				</tbody>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_deliveries',array('inline'=>false));?>