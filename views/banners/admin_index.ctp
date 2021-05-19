<?php echo $this->Html->addCrumb('Dashboard','/admin/'); ?>
<?php echo $this->Html->addCrumb('Banners',''); ?>
<div ng-controller="AdminBannersController" ng-init="initializeController()">	
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-4">
			<input ng-model="q" id="search" class="form-control input-sm" placeholder="Search">
		</div>
		<div class="col-lg-2 col-md-2 col-xs-2 col-lg-offset-6 col-md-offset-6 col-xs-offset-6">
			<input placeholder="Banners per page" type="number" min="1" max="100" class="form-control input-sm ng-pristine ng-valid ng-valid-number ng-valid-max ng-valid-min" ng-model="pageSize">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<table class="table table-striped table-hovered">
				<thead>
					<tr>
						<th colspan="5">BANNERS</th>
						<th colspan="1">
							<a href = "<?php echo $this->base;?>/admin/banners/add" class="btn btn-sm btn-success pull-right">
								<i class="fa fa-plus-circle"></i> New Banner
							</a>
						</th>
					</tr>
					<tr>
						<th>Name</th>
						<th>Image</th>
						<th>Caption</th>
						<th>Created</th>
						<th>Modified</th>
						<th class="actions text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr class="ng-cloak" pagination-id="BannerListTable" dir-paginate="d in banners | filter:q | itemsPerPage: pageSize" current-page="currentPage">
						<td>{{d.Banner.name}}</td>
						<td>
							<img src="<?php echo $this->base;?>/img/banner/thumb/small/{{d.Banner.img_file}}" class="img-responsive img-thumbnail" alt="">
						</td>
						<td>{{d.Banner.caption}}</td>
						<td>{{d.Banner.created}}</td>
						<td>{{d.Banner.modified}}</td>
						<td class="actions text-center">
							<a href="<?php echo $this->base;?>/admin/banners/edit/{{d.Banner.id}}" data-toggle="tooltip" title="Edit Name & Caption"><i class="fa fa-edit"></i></a> |
							<a href="<?php echo $this->base;?>/admin/banners/delete/{{d.Banner.id}}" onclick="return confirm('Are you sure you want to delete this banner?');" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<tr ng-show="loading">
						<td colspan="6">
							<center>
								<img class="loading" ng-src="<?php echo $this->base;?>/img/loading2.gif"></img>
							</center>
						</td>
					</tr>
					<tr class="ng-cloak" ng-show="(banners | filter:q).length == 0 && !loading" pagination-id="BannerListTable" >
						<td colspan="6">
							<center><img class="loading" ng-src="<?php echo $this->base;?>/img/no-record-found.png"></img></center>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="text-center">
							<dir-pagination-controls pagination-id="BannerListTable"></dir-pagination-controls>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Html->script('controllers/admin_banners',array('inline'=>false));?>