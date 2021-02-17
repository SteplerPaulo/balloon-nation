App.controller('AdminBannersController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		$scope.loading = true;
		
		
		
		$http.get(BASE_URL+"banners/all").success(function(response) {
			$scope.banners = response;
			$scope.loading = false;
		});
	}
});