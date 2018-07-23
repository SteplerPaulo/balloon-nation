App.controller('AdminSalesController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.loading = true;
		$scope.src = '';
		$scope.customer_id = window.location.pathname.split('/')[5];
		$scope.customer_name = decodeURI(window.location.pathname.split('/')[6]);
			
		$http.get(BASE_URL+"sales/customer_sales/"+$scope.customer_id).success(function(response) {
			console.log(response);
			$scope.sales = response;
			$scope.loading = false;
			if(!$scope.loading) $scope.src = '/balloon-nation/img/no-record-found.png';
		});
	}
});

