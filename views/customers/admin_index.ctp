<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Customers',''); ?>
<div ng-controller="AdminCustomersController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<input ng-model="q" id="search" class="form-control input-sm" placeholder="Search">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-6 col-md-offset-6 col-xs-offset-6">
			<input placeholder="Customers per page" type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="2">CUSTOMERS</th>
						<th colspan="1"><a href = "<?php echo $this->base;?>/admin/customers/add" class="btn btn-sm btn-success pull-right">New Customer</a></th>
					</tr>
					<tr>
						
						<th>Name</th>
						<th>Compcode</th>
						<th class="actions text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr class="ng-cloak" pagination-id="CustomerListTable" dir-paginate="d in customers | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>
							<h4>{{d.Customer.name}}</h4>
							{{d.Customer.address}}
						</td>
						<td>{{d.Customer.compcode}}</td>
				
						<td class="actions text-center">
							<a href="<?php echo $this->base;?>/admin/customers/edit/{{d.Customer.slug}}" data-toggle="tooltip" title="Edit Customer Details"><i class="fa fa-edit"></i></a>
							<a href="<?php echo $this->base;?>/admin/customers/clone/{{d.Customer.slug}}" data-toggle="tooltip" title="Clone New Products">
								<i class="fa fa-clone"></i>
							</a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="3">
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr class="ng-cloak" ng-show="(customers | filter:q).length == 0 && !loading" pagination-id="CustomerListTable" >
						<td colspan="3">
							<center><img class="loading" ng-src="<?php echo $this->base;?>/img/no-record-found.png"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" class="text-center">
							<dir-pagination-controls pagination-id="CustomerListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_customers',array('inline'=>false));?>