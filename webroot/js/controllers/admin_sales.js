App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"products/sales_report").success(function(response) {
			$scope.products = response.Products;
			$scope.costumers = response.Costumers;
			console.log($scope.products);
			$scope.costumer = $scope.costumers[0].Costumer.name;
		});
	}

});


