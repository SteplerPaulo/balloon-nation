App.controller('AdminCategoriesController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
		$scope.loading = true;
		$scope.src = '';
		
		
		$http.get(BASE_URL+"categories/main_children").success(function(response) {
			$scope.categories = response;
			$scope.loading = false;
			if(!$scope.loading) $scope.src = '/balloon-nation/img/no-record-found.png';
		});
	}
	
});