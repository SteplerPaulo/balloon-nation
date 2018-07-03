App.controller('DashboardController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		
		$http.get(BASE_URL+"/users/dashboard_updates").success(function(response) {
			$scope.forDelivery = response.ForDelivery;
			$scope.forPosting = response.ForPosting;
			
			
		});
	}
});
