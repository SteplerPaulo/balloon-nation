App.controller('AdminDeliveriesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		$scope.loading = true;
		
		$http.get(BASE_URL+"customers/all").success(function(response) {
			$rootScope.customers = response;
			if($rootScope.customer ==  undefined){
				$rootScope.customer = '';
			}
		});
		
		$http.get(BASE_URL+"deliveries/all").success(function(response) {
			$scope.deliveries = response;
			$scope.loading = false;
		});		
	}
});