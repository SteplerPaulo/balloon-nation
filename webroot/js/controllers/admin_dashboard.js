App.controller('DashboardController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$http.get(BASE_URL+"customers/all").success(function(response) {
			$rootScope.customers = response;
		});
	}
});