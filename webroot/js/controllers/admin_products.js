App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"products/all").success(function(response) {
			$scope.products = response.Products;
			console.log($scope.products);
			$rootScope.costumers = response.Costumers;
			if($rootScope.costumer ==  undefined){
				$rootScope.costumer = $rootScope.costumers[0].Costumer.name;
			}
			
		});
	}
});

