<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Customers',''); ?>
<div ng-controller="AdminCustomersController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-12 col-xs-12">
			<label class="hidden-lg">Search</label>
			<input ng-model="q" id="search" class="form-control input-sm" placeholder="Search">
		</div>
		<div class="col-lg-2 col-md-12 col-xs-12 col-lg-offset-6">
			<label class="hidden-lg">Item per page</label>
			<input placeholder="Customers per page" type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div><br/>
	<div class="row">
		<div class="hidden-sm hidden-xs col-lg-10">
			<h4>CUSTOMERS</h4>
		</div>
		<div class="col-lg-2 col-md-12 col-sm-12">
			<a href="<?php echo $this->base;?>/admin/customers/add" 
			   class="btn btn-sm btn-success btn-block"><i class="fa fa-plus-circle"></i> New Customer
			</a>	
		</div>
	</div><br class="hidden-lg"/>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-striped table-hovered">
				
				<tbody>
					<tr class="ng-cloak" pagination-id="CustomerListTable" dir-paginate="d in customers | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>
							{{d.Customer.name}}
							<div>
								<small class="text-muted text-sm">
									Address: {{d.Customer.address}} | Compcode: {{d.Customer.compcode}}
								</small>
							</div>
						</td>
				
						<td class="text-right">
							<a href="<?php echo $this->base;?>/admin/customers/edit/{{d.Customer.slug}}" data-toggle="tooltip" title="Edit Customer Details"><i class="fa fa-edit fa-2x"></i></a>
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
						<td colspan="2">
							<center><img class="loading" ng-src="<?php echo $this->base;?>/img/no-record-found.png"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" class="text-center">
							<dir-pagination-controls pagination-id="CustomerListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_customers',array('inline'=>false));?>