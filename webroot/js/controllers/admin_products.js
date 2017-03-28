App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"products/all").success(function(response) {
			$scope.products = response.Products;
			console.log($scope.products);
			$rootScope.customers = response.Customers;
			if($rootScope.customer ==  undefined){
				$rootScope.customer = $rootScope.customers[0].Customer.name;
			}
			
		});
	}
});

