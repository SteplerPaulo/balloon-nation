App.controller('ProductsController',function($scope,$rootScope,$http,$filter){

	$scope.initializeController = function(){
		$scope.currentPage = 1;
		$scope.categoryLimit = false;
		$scope.showLoadBtn = false;
		$scope.endResult = false;
		$scope.limit = 15;
		
		$http.get(BASE_URL+"categories/main_children").success(function(response) {
			$scope.categories = response;
		});
			
		$http.get(BASE_URL+"products/main_products").success(function(response) {
			$scope.products = response;
			if (document.location.hostname == "localhost"){
				if(window.location.pathname.split('/')[3]){
					$scope.productFilter = window.location.pathname.split('/')[3];
				}
			}else{
				if(window.location.pathname.split('/')[2]){
					$scope.productFilter = window.location.pathname.split('/')[2];
				}
			}
			$scope.showLoadBtn = true;
		});
	}
	
	$scope.loadMore = function() {
		$scope.limit += 15;
		if($scope.limit < $scope.filteredProducts.length){
			$scope.showLoadBtn = true;
		}else{
			$scope.showLoadBtn = false;
			$scope.endResult = true;
		}
	};
});
App.directive("directiveWhenScrolled", function() {
  return function(scope, elm, attr) {
    var raw = elm[0];

    elm.bind('scroll', function() {
      if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
        scope.$apply(attr.directiveWhenScrolled);
      }
    });
  };
});