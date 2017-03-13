App.controller('CategoriesController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 11;
		
		
		$http.get(BASE_URL+"categories/main_children").success(function(response) {
			$scope.categories = response;
		});
	}
	
});