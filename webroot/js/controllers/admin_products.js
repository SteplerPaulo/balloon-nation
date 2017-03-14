App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"products/all").success(function(response) {
			$scope.products = response.Products;
			console.log($scope.products);
			$rootScope.costumers = response.Costumers;
			if($rootScope.costumer ==  undefined){
				$rootScope.costumer = $rootScope.costumers[0].Costumer.name;
			}
			
		});
	}
	
	$rootScope.openPricing = function (data,size, parentSelector) {
		var parentElem = parentSelector ? 
			angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
		var modalInstance = $uibModal.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: 'PricingModal.html',
			controller: 'PricingModalCtrl',
			controllerAs: '$ctrl',
			size: size,
			appendTo: parentElem,
			resolve: {
				data: function () {
					return data;
				}
			}
		});
	};

});

App.controller('PricingModalCtrl', function ($rootScope,$uibModalInstance, data,$filter,$http) {
	var $ctrl = this;
	$ctrl.data = data;
	
	if($ctrl.data.ProductPricing.length){
		$ctrl.purchase_price = parseFloat($ctrl.data.ProductPricing[0].purchase_price);
		$ctrl.selling_price = parseFloat($ctrl.data.ProductPricing[0].selling_price);
	}else{
		$ctrl.purchase_price = 0.00;
		$ctrl.selling_price = 0.00;
	}

	
	
	$ctrl.save = function () {
		var data = {'ProductPricing':{
						'product_id':$ctrl.data.Product.id,
						'purchase_price':$ctrl.purchase_price,
						'selling_price':$ctrl.selling_price,
					}
				};
		
		$.ajax({
			method: 'POST',
			url: BASE_URL+'admin/product_pricings/add/',
			dataType:'json',
			data: $.param({data:data}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function(response) {
			$uibModalInstance.close('');
			$rootScope.initializeController();
		});
		
	};
	
	
	$ctrl.close = function () {
		$rootScope.initializeController();
		$uibModalInstance.close('');
	};
});

