App.controller('AdminCostumersController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"costumers/all").success(function(response) {
			$scope.costumers = response;
		});
	}
});