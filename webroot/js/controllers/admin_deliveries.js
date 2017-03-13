App.controller('AdminDeliveriesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		
		$http.get(BASE_URL+"costumers/all").success(function(response) {
			$rootScope.costumers = response;
			if($rootScope.costumer ==  undefined){
				$rootScope.costumer = '';
			}
		});
		
		$http.get(BASE_URL+"deliveries/all").success(function(response) {
			$scope.deliveries = response;
		});		
	}
});