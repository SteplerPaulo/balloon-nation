App.controller('CloneProductController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 45;
		$scope.loading = true;
		$scope.customer = null;
			
		//console.log(decodeURI(window.location.pathname.split('/')[5]));	
			
		if (document.location.hostname == "localhost"){
			if(window.location.pathname.split('/')[5]){
				$scope.customer_slug = decodeURI(window.location.pathname.split('/')[5]);
			}
		}else{
			if(window.location.pathname.split('/')[2]){
				$scope.customer_slug = decodeURI(window.location.pathname.split('/')[4]);
			}
		}
			
	 	$http.get(BASE_URL+"customers/test/"+$scope.customer_slug).success(function(response) {
			$scope.customer_id = response.New.Customer.id;
			$scope.customer = response.New.Customer.name;
			$scope.data = response.BalloonationProducts;
			$scope.loading = false;
		});
	}
	
	$scope.change = function(i){
		$scope.data[i].Product.initial_inventory = $scope.data[i].Product.beginning_inventory;
	}
	
	$scope.save = function(){
		
		$http({
			method: 'POST',
			url: BASE_URL+'/customers/save_clone_data',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:$scope.data})
		}).then(function(response){
			console.log(response);
			if(response.status){
				
				//window.location.href = BASE_URL+"admin/customers";
			}else{
				//alert('Error: Customer product cloning can not be save. Pls. contact system administrator.');
			}
		});
		
		
	}
	
	
}).run(function($rootScope) {
  $rootScope.typeOf = function(value) {
    return typeof value;
  };
}).directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value);
      });
    }
  };
});