App.controller('AdminSalePostingController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		
		$scope.SaleID =  $("#SalePostingPanel").attr('sale-id');
		$http.get(BASE_URL+"sales/posting_data/"+$scope.SaleID).success(function(response) {
			$scope.Customer = response.Customer;
			$scope.Sale = response.Sale;
			$scope.SaleDetail = response.SaleDetail;
		
		});
	}


	$scope.post = function (){
	
		var data = {'Sale':{
						'id':$scope.Sale.id,
						'is_posted':1,
					}};
			data['Product'] = [];
			
		for (var i = 0; i < $scope.SaleDetail.length; i++) {
			data['Product'][i] = {
							'id':$scope.SaleDetail[i].product_id,
							'beginning_inventory':$scope.SaleDetail[i].beginning_inventory,
							'missing_qty':$scope.SaleDetail[i].missing_qty,
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


