App.controller('AdminSalePostingController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
		$scope.preventDoubleClick = false;
		
		$scope.SaleID =  $("#SalePostingPanel").attr('sale-id');
		$http.get(BASE_URL+"sales/posting_data/"+$scope.SaleID).success(function(response) {
			$scope.data = response;
			console.log(response);
		
		});
	}

	$scope.changeActualInventory = function(i,o){
		
		$scope.data.SaleDetail[i].missing_qty = o.in_stock - $scope.data.SaleDetail[i].actual_inventory;
		
	}

	$scope.post = function (){
		$scope.preventDoubleClick = true;
	
		var data = {'Sale':{
						'id':$scope.data.Sale.id,
						'is_posted':1,
						'SaleDetail':$scope.data.SaleDetail,
					}};
			data['Product'] = {};
			
		for (var i = 0; i < $scope.data.SaleDetail.length; i++) {
			//console.log($scope.data.SaleDetail[i]);
			data['Product'][i] = {
							'id':$scope.data.SaleDetail[i].product_id,
							'beginning_inventory':$scope.data.SaleDetail[i].actual_inventory,
							'missing_qty':$scope.data.SaleDetail[i].missing_qty,
						};
		}
		
		//console.log(data);
		
		$http({
			method: 'POST',
			url: BASE_URL+'sales/posting_saving',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:data})
		}).then(function(response){
			window.location.href = BASE_URL+"admin/sales/index/"+$scope.data.Customer.id+'/'+$scope.data.Customer.name;
		});
		
		
	}
	
});


