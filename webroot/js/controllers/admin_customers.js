App.controller('AdminCustomersController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
			
		$http.get(BASE_URL+"customers/all").success(function(response) {
			$scope.customers = response;
		});
	}
});