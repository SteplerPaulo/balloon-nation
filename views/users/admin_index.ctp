<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Users',''); ?>
<div ng-controller="AdminUsersController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<label for="search">Search</label>
			<input ng-model="q" id="search" class="form-control input-sm" placeholder="Filter text">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-6 col-md-offset-6 col-xs-offset-6">
			<label for="search">Items per page</label>
			<input type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div><br/>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="4">USERS</th>
					</tr>
					<tr>
						<th>ID</th>
						<th>Username</th>
						<th>Full Name</th>
						<th class="actions text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr pagination-id="ProductListTable" dir-paginate="d in users | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.User.id}}</td>
						<td>{{d.User.username}}</td>
						<td>{{d.User.full_name}}</td>
						<td class="actions text-center">
							<a ng-if="d.User.is_admin" ng-click="removeAsAdmin(d)" data-toggle="tooltip" title="Remove as Admin" class="btn btn-success"><i class="fa fa-user-times" aria-hidden="true"></i></a>
							<a ng-if="d.User.is_admin == 0" ng-click="addAsAdmin(d)"  data-toggle="tooltip" title="Add as Admin" class="btn btn-warning"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" class="text-center">
							<dir-pagination-controls pagination-id="ProductListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="Modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<?php echo $form->create('User',array('action'=>'assign')); ?>
				<div class="modal-body"><br/><br/>
					<div class="row">
						<div class="col-lg-12">
							<h4>{{ModalMessage}}</h4>
						</div>
					</div><br/><br/>
					<div class="row">
						<div class="col-lg-12 hide">
							<div class="input select">
								<label for="UserUserId">User</label>
								<input name="data[User][user_id]" type="text" ng-model="UserId" class="form-control">
							</div>
							<div class="input text">
								<label for="UserRoles">Roles</label>
								<input name="data[User][roles]" type="text" ng-model="ArosId" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Confirm</button>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_users',array('inline'=>false));?>


