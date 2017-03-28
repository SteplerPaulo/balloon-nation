App.controller('ProductsController',function($scope,$rootScope,$http,$filter){

	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize =12;
		$http.get(BASE_URL+"categories/main_children").success(function(response) {
			$scope.categories = response;
		});
			
		$http.get(BASE_URL+"products/main_products").success(function(response) {
			$scope.products = response;
			console.log($scope.products);
			
			if (document.location.hostname == "localhost" || document.location.hostname == "192.168.1.10"){
				if(window.location.pathname.split('/')[3]){
					$scope.productFilter = window.location.pathname.split('/')[3];
				}
			}else{
				if(window.location.pathname.split('/')[2]){
					$scope.productFilter = window.location.pathname.split('/')[2];
				}
			}
		
		});
	}
});