App.controller('HomeController',function($scope,$rootScope,$http,$filter){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.bannerLimit = false;
		$scope.categoryLimit = false;
		$scope.productLimit = 6;
		$scope.imageLimit = 6;
			
		$http.get(BASE_URL+"categories/main_children").success(function(response) {
			$scope.categories = response;
			
		});
		
		$http.get(BASE_URL+"products/main_products").success(function(response) {
			$scope.products = response;
		});
		
		$http.get(BASE_URL+"banners/active").success(function(response) {
			$scope.banners = response;
		});
	}
});