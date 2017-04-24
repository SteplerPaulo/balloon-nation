App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
			
		if (document.location.hostname == "localhost"){
			if(window.location.pathname.split('/')[5]){
				$rootScope.customer = decodeURI(window.location.pathname.split('/')[5]);
			}
		}else{
			if(window.location.pathname.split('/')[2]){
				$rootScope.customer = decodeURI(window.location.pathname.split('/')[4]);
			}
		}
		
		$http.get(BASE_URL+"products/all").success(function(response) {
			$scope.products = response.Products;
			
			$rootScope.customers = response.Customers;
			if($rootScope.customer ==  undefined || $rootScope.customer ==  'undefined'){
				$rootScope.customer = $rootScope.customers[0].Customer.name;
			}
			
		});

	}
});

