App.controller('AdminDeliveriesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 8;
		$scope.loading = true;
		$scope.customer_id = window.location.search.split('&')[0].substring(1);
		$scope.customer_name = decodeURI(window.location.search.split('&')[1]);
		
		
		$http.get(BASE_URL+"customers/deliveries/"+$scope.customer_id).success(function(response) {
			$scope.deliveries = response;
			$scope.loading = false;
		});
		
	}
});