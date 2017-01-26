<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Categories',''); ?>
<div ng-controller="AdminCategoriesController" ng-init="initializeController()">
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
					<tr >
						<th colspan="2">CATEGORIES</th>
						<th colspan="1"><a href = "<?php echo $this->base;?>/admin/categories/add" class="btn btn-sm btn-warning pull-right">Add New Category</a></th>
					</tr>
					<tr>
						<th>Name</th>
						<th>Slug</th>
						<th class="actions text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr pagination-id="ProductListTable" dir-paginate="d in categories | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Category.name}}</td>
						<td>{{d.Category.slug}}</td>
						<td class="actions text-center">
							<a href="<?php echo $this->base;?>/admin/categories/edit/{{d.Category.slug}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> |
							<a href="<?php echo $this->base;?>/admin/categories/delete/{{d.Category.id}}" onclick="return confirm('Are you sure you want to delete this category?');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" class="text-center">
							<dir-pagination-controls pagination-id="ProductListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_categories',array('inline'=>false));?>


