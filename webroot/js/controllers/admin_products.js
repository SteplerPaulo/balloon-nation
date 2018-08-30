App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 17;
		$scope.loading = true;
		$scope.src = '';
			
		/*DONT KNOW WHAT THE USE OF THIS CODE
		if (document.location.hostname == "localhost"){if(window.location.pathname.split('/')[5]){$rootScope.customer = decodeURI(window.location.pathname.split('/')[5]);}
		}else{
			if(window.location.pathname.split('/')[2]){$rootScope.customer = decodeURI(window.location.pathname.split('/')[4]);	}
		}*/
		
		
		$http.get(BASE_URL+"/products/customers").success(function(response) {
			$rootScope.customers = response;
			if($rootScope.customer ==  undefined || $rootScope.customer ==  'undefined'){
				$rootScope.customer = 'Balloon Nation';
			}
		});
		
		
		$http.get(BASE_URL+"/admin/products/init").success(function(response) {
			$scope.products = response;
			$scope.loading = false;
			if(!$scope.loading){
				$scope.src = '/balloon-nation/img/no-record-found.png';
			}
		});

	}
	
	$scope.changeCustomer = function(){
		$scope.loading = true;
		$http.get(BASE_URL+"/admin/products/init/"+$scope.customer).success(function(response) {
			$scope.products = response;
			$scope.loading = false;
			if(!$scope.loading) $scope.src = '/balloon-nation/img/no-record-found.png';
			
		});
	} 
});

