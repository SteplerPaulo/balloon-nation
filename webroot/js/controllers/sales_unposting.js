App.controller('SalesReportUnposting',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.preventDoubleClick = false;
		$http.get(BASE_URL+"sales/customers").success(function(response) {
			$scope.customers = response;
		});	
	}
	
	$scope.changeCustomer = function(){
		$scope.preventDoubleClick = false;
	}
	
	
	$scope.unposting = function(){
		$scope.preventDoubleClick = true;
		console.log($scope.selected);
	
		$http({
			method: 'POST',
			url: BASE_URL+'sales/unpost_customer_sales',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:$scope.selected})
		}).then(function(response){
			console.log(response.statusText);
			if(response.statusText=='OK'){
				alert('Customer Sales Report Unposted: '+$scope.selected.Customer.name);
				$scope.selected = "";
			}
		});
		
		
	}
});

