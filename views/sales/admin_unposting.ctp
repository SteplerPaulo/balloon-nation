<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Unposting'); ?>
<div ng-controller="SalesReportUnposting" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="panel-title">Unposting</span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<label>Customer</label>
							<select ng-change="changeCustomer()" class='form-control input-sm' ng-model="selected" ng-options="o.Customer.name for o in customers">
								<option value="">--Select--</option>
							</select>
						</div>
					</div>
				</div>
				<div class="panel-footer text-right">
					<button ng-disabled="!selected || preventDoubleClick" class="btn btn-primary" ng-click="unposting()">Unpost</button>
				</div>
			</div>
		</div>
		
	</div>
</div>
<?php echo $this->Html->script('controllers/sales_unposting',array('inline'=>false));?>
