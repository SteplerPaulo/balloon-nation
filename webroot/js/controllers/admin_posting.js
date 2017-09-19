App.controller('AdminSalePostingController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
		
		$scope.SaleID =  $("#SalePostingPanel").attr('sale-id');
		$http.get(BASE_URL+"sales/posting_data/"+$scope.SaleID).success(function(response) {
			$scope.data = response;
		
		});
	}

	$scope.changeActualInventory = function(i,o){
		
		$scope.data.SaleDetail[i].missing_qty = o.in_stock - $scope.data.SaleDetail[i].actual_inventory;
		
	}

	$scope.post = function (){
	
		var data = {'Sale':{
						'id':$scope.data.Sale.id,
						'is_posted':1,
						'SaleDetail':$scope.data.SaleDetail,
					}};
			data['Product'] = [];
			
		for (var i = 0; i < $scope.data.SaleDetail.length; i++) {
			data['Product'][i] = {
							'id':$scope.data.SaleDetail[i].product_id,
							'beginning_inventory':$scope.data.SaleDetail[i].actual_inventory,
							'missing_qty':$scope.data.SaleDetail[i].missing_qty,
						};
						
		}
		
			
		console.log(data);
		//return;
		$http({
			method: 'POST',
			url: BASE_URL+'sales/posting_saving',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:data})
		}).then(function(response){
			window.location.href = BASE_URL+"admin/sales";
		});
		
		
	}
	
	
});


