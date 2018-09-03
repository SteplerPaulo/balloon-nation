App.controller('AdminDeliveriesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 12;
		$scope.loading = true;
		$scope.src = '';
		
		$http.get(BASE_URL+"deliveries/customers").success(function(response) {
			$rootScope.customers = response;
			if($rootScope.customer ==  undefined){
				$rootScope.customer = '';
			}
		});
		
		$http.get(BASE_URL+"deliveries/all").success(function(response) {
			$scope.deliveries = response;
			$scope.loading = false;
			if(!$scope.loading) $scope.src = '/balloon-nation/img/no-record-found.png';
		});		
	}
});