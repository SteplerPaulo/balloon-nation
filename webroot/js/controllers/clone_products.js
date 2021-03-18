App.controller('CloneProductController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 45;
		$scope.loading = true;
		$scope.customer = null;
		$scope.preventDoubleClick = false;
		$scope.check_all = false;
			
		//console.log(decodeURI(window.location.pathname.split('/')[5]));	
			
		if (document.location.hostname == "localhost" || document.location.hostname == "192.168.254.130"){
			if(window.location.pathname.split('/')[5]){
				$scope.customer_slug = decodeURI(window.location.pathname.split('/')[5]);
			}
		}else{
			if(window.location.pathname.split('/')[2]){
				$scope.customer_slug = decodeURI(window.location.pathname.split('/')[4]);
				//console.log(decodeURI(window.location.pathname.split('/')[4]);
			}
		}
	 	
		$http.get(BASE_URL+"customers/test/"+$scope.customer_slug).success(function(response) {
		
			$scope.customer_id = response.Customer.Customer.id;
			$scope.customer = response.Customer.Customer.name;
			$scope.data = response.BalloonationProducts;
			$scope.loading = false;
		});
	}
	
	$scope.change = function(i){
		$scope.data[i].Product.initial_inventory = $scope.data[i].Product.beginning_inventory;
	}
	
	
	$scope.checkAll = function (is_checked) {
		if(is_checked){
			$scope.selected_item_count = 0;
			for (var i = 0; i < $scope.data.length; i++) {
				$scope.data[i].Product.is_disabled = false;
				$scope.data[i].Product.checkbox = true;
				$scope.selected_item_count++;
			}
		}else{
			for (var i = 0; i < $scope.data.length; i++) {
				$scope.data[i].Product.is_disabled = true;
				$scope.data[i].Product.checkbox = false;
				$scope.selected_item_count--;
			}
		}
	};
	
	
	$scope.check = function (i,is_checked) {
		if(is_checked){
			$scope.data[i].Product.is_disabled = false;
			$scope.selected_item_count++;
		}else{
			$scope.data[i].Product.is_disabled = true;
			$scope.check_all = false;
			$scope.selected_item_count--;
		}
	};
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$scope.save = function(){
		$scope.preventDoubleClick = true;
		let postData = [];
		angular.forEach($scope.data, function(value, key) {
			if(!value.Product.is_disabled){
				postData.push(value)
			}
		});
		
		$http({
			method: 'POST',
			url: BASE_URL+'/customers/save_clone_data',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:postData})
		}).then(function(response){
			//console.log(response);
			
			if(response.status){
				window.location.href = BASE_URL+"admin/customers";
			}else{
				alert('Error: Customer product cloning can not be save. Pls. contact system administrator.');
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