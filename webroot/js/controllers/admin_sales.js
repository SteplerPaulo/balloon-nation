App.controller('AdminSalesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.loading = true;
		$scope.customer_id = window.location.search.split('&')[0].substring(1);
		$scope.customer_name = decodeURI(window.location.search.split('&')[1]);
			
		$http.get(BASE_URL+"sales/customer_sales/"+$scope.customer_id).success(function(response) {
			$scope.sales = response;
			$scope.loading = false;
		});
	}
});

