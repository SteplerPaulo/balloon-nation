<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales Report','/admin/sales/customer'); ?>
<?php echo $this->Html->addCrumb('Customer'); ?>
<div ng-controller="AdminSalesController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3 class="ng-cloak">{{customer_name | uppercase}} - MONTHLY SALES REPORTS</h3>
			<table class="table table-striped table-condensed ">
				<thead>
					<tr>
						<th class="">Date</th>
						<th class="text-center w10">Action</th>
					</tr>
				</thead>
				<tbody class="ng-cloak">
					<tr ng-if="sales.length" ng-repeat="d in sales">
						<td class="">{{d.Sale.from_date | date: "MMMM yyyy"}}</td>
						<td class="actions text-center">
							<a ng-if="d.Sale.is_posted == 0" href="<?php echo $this->base;?>/admin/sales/posting/{{d.Sale.id}}" title="Posting"><i class="fa fa-gavel"></i></a>
							<a ng-if="d.Sale.is_posted == 1" target="_blank" href="<?php echo $this->base;?>/admin/sales/report/{{d.Sale.id}}" title="Print"><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="2">
							<center>
								<img class="loading"src="<?php echo $this->base;?>/img/loading.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-if="!sales.length && !loading">
						<td colspan="2">
							<center><img class="loading" ng-src="<?php echo $this->base;?>/img/no-record-found.png"></img></center>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_sales',array('inline'=>false));?>
