<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Sales Report'); ?>
<div ng-controller="SalesReportCustomer" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="panel-title">Sales Report</span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<label>Customer</label>
							<select class='form-control input-sm' ng-model="selected" ng-options="o.Customer.name for o in customers">
								<option value="">--Select--</option>
							</select>
						</div>
					</div>
				</div>
				<div class="panel-footer text-right">
					<a ng-disabled="selected == null" href="<?php echo $this->base;?>/admin/sales/index/{{selected.Customer.id}}/{{selected.Customer.name}}" class="btn btn-primary">Open Report(s)</a>
				</div>
			</div>
		</div>
		
	</div>
</div>
<?php echo $this->Html->script('controllers/sales_report_customer',array('inline'=>false));?>
