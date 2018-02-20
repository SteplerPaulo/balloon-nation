App.controller('AdminSalesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 10;
		$scope.loading = true;
		$scope.src = '';
			
		$http.get(BASE_URL+"sales/customers").success(function(response) {
			$scope.customers = response;
			if($scope.customer ==  undefined){
				$scope.customer = '';
			}
		});	
			
		$http.get(BASE_URL+"sales/all").success(function(response) {
			$scope.sales = response;
			$scope.loading = false;
			if(!$scope.loading) $scope.src = '/balloon-nation/img/no-record-found.png';
		});
	}

});

