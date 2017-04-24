App.controller('AdminSalesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
			
		$http.get(BASE_URL+"customers/all").success(function(response) {
			$scope.customers = response;
			if($scope.customer ==  undefined){
				$scope.customer = '';
			}
		});	
			
		$http.get(BASE_URL+"sales/all").success(function(response) {
			$scope.sales = response;
		});
	}

});


