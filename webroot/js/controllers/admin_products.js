App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 17;
		$scope.loading = true;
			
		$scope.customer_id = window.location.search.split('&')[0].substring(1);
		$scope.customer_name = decodeURI(window.location.search.split('&')[1]);
		

		$http.get(BASE_URL+"customers/products/"+$scope.customer_id).success(function(response) {
			$scope.products = response;
			$scope.loading = false;
		});
		
	}
	
});

