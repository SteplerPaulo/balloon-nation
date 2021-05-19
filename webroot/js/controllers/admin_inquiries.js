App.controller('AdminInquiriesController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
		$scope.loading = true;
		
		
		$http.get(BASE_URL+"inquiries/all").success(function(response) {
			$scope.inquiries = response;
			$scope.loading = false;
		});
	}
	
});