<div ng-controller="AdminDeliveriesController" ng-init="initializeController()">
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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-responsive table-striped table-hovered">
				<tbody>
					<tr class="ng-cloak" pagination-id="ListTable" dir-paginate="d in deliveries | filter:q | filter:customer | itemsPerPage: pageSize" current-page="currentPage">
						<td> 
							<div>{{d.Customer.name}}</div>
							<small class="text-muted">
								<a title="Date">{{d.Delivery.formated_date}}</a> | 
								<a title="Clerk">{{d.Delivery.stock_clerk}}</a> |
								<a title="Receipt No.">{{d.Delivery.delivery_receipt_no}}</a>
							</small>
						</td>
						<td class="text-right">
							<a href="<?php echo $this->base;?>/admin/deliveries/report/{{d.Delivery.id}}" title="Print" target="_blank"><i class="fa fa-print fa-2x"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td>
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-show="(deliveries | filter:q | filter:customer).length == 0" pagination-id="ListTable" >
						<td>
							<center><img class="loading" ng-src="{{src}}"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-center" colspan="2">
							<dir-pagination-controls max-size="7" pagination-id="ListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_deliveries',array('inline'=>false));?>