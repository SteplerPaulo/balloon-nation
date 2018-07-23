App.controller('SalesReportCustomer',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$http.get(BASE_URL+"sales/customers").success(function(response) {
			$scope.customers = response;
		});	
	}
});

