<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Inquiries',''); ?>
<div ng-controller="AdminInquiriesController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<input ng-model="q" id="search" class="form-control input-sm" placeholder="Search">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-6 col-md-offset-6 col-xs-offset-6">
			<input placeholder="Inquiries per page" type="number" min="1" max="100" class="form-control input-sm" ng-model="pageSize">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<table class="table table-striped table-hovered ">
				<thead>
					<tr>
						<th colspan="4">INQUIRIES</th>
					</tr>
					<tr>
						<th>From</th>
						<th>Subject</th>
						<th>Created</th>
						<th class="actions text-center">Action</th>
					</tr>
				</thead>
				<tbody class="ng-cloak">
					<tr pagination-id="InquiryListTable" dir-paginate="s in inquiries | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{s.Inquiry.from}}</td>
						<td>{{s.Inquiry.subject}}</td>
						<td>{{s.Inquiry.created}}</td>
						<td class="actions text-center">
							<a data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="3">
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading.gif"></img>
							</center>
						</td>
					</tr>
					<tr ng-show="(inquiries | filter:q).length == 0 && !loading" pagination-id="InquiryListTable" >
						<td colspan="2">
							<center><img class="loading" ng-src="<?php echo $this->base;?>/img/no-record-found.png"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" class="text-center">
							<dir-pagination-controls pagination-id="InquiryListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>	
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_inquiries',array('inline'=>false));?>