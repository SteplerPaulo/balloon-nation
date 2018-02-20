App.controller('AdminCustomersController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 6;
		$scope.loading = true;
		$scope.src = '';
			
		$http.get(BASE_URL+"customers/all").success(function(response) {
			$scope.customers = response;
			$scope.loading = false
			if(!$scope.loading) $scope.src = '/balloon-nation/img/no-record-found.png';
			
		});
	}
});