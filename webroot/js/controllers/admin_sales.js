App.controller('AdminSalesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"costumers/all").success(function(response) {
			$scope.costumers = response;
			if($scope.costumer ==  undefined){
				$scope.costumer = '';
			}
		});	
			
		$http.get(BASE_URL+"sales/all").success(function(response) {
			$scope.sales = response;
		});
	}

});


