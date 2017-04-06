App.controller('ProductAddController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	
	
	$scope.initializeController = function(){
		
		
	}
	
	$scope.getItemCodeData = function(item_code){
		$http.get(BASE_URL+"products/by_itemcode/"+item_code).success(function(response) {
	
			$scope.product_name = response.Product.name;
			$scope.category_id = response.Product.category_id;
			$scope.min = parseFloat(response.Product.min,2);
			$scope.purchase_price = parseFloat(response.Product.purchase_price,2);
			$scope.selling_price =parseFloat(response.Product.selling_price,2);
		});
	}
	

});