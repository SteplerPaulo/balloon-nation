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
	
	$rootScope.openTransaction = function (data,size, parentSelector) {
		$.ajax({
			method: 'POST',
			url: BASE_URL+'admin/product_transactions/get/',
			dataType:'json',
			data: $.param({data:{
							'product_id':data.Product.id,
							'last_date_posted':data.Product.last_date_posted,
							'posted_quantity':data.Product.posted_quantity}
						}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function(response) {
			
			var ProductData = {
								'Basic':{data},
								'Transactions':{response}
							};
			
			var parentElem = parentSelector ? 
				angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
			var modalInstance = $uibModal.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
				ariaDescribedBy: 'modal-body',
				templateUrl: 'myModalContent.html',
				controller: 'TransactionModalCtrl',
				controllerAs: '$ctrl',
				size: size,
				appendTo: parentElem,
				resolve: {
					ProductData: function () {
						return ProductData;
					}
				}
			});
			
		});
	};
	
	
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


App.controller('TransactionModalCtrl', function ($rootScope,$uibModalInstance, ProductData,$filter,$http) {
	console.log(ProductData);
	var $ctrl = this;
	$ctrl.data = ProductData.Basic.data;
	
	$ctrl.transactions = ProductData.Transactions.response;
	$ctrl.dateNow = new Date($filter("date")(Date.now(), 'yyyy-MM-dd HH:mm:ss'));
	
	$ctrl.TotalReturnedQty =  $ctrl.transactions.TotalReturnedQty;
	$ctrl.TotalDeliveredQty =  $ctrl.transactions.TotalDeliveredQty;
	$ctrl.CurrentQuantity = $ctrl.data.Product.current_quantity;
	$ctrl.PostedQuantity = $ctrl.data.Product.posted_quantity;
	
	if(!$ctrl.data.ProductPricing.length){
		alert('Selling Price not Yet Indicated.');
		$uibModalInstance.close('');
	}
	
	$ctrl.ProductPriceId = $ctrl.data.ProductPricing[0].id;
	$ctrl.selling_price = $ctrl.data.ProductPricing[0].selling_price;
	$ctrl.purchase_price = $ctrl.data.ProductPricing[0].purchase_price;
	$ctrl.price_is_new = $ctrl.data.ProductPricing[0].is_new;
	console.log($ctrl.price_is_new);

	
	$ctrl.toggleQty =  function(counted_qty,returned_qty,delivered_qty){
		//RETURN QTY
		if(returned_qty >= 0){
			$ctrl.TotalReturnedQty = $ctrl.transactions.TotalReturnedQty+returned_qty;
		}else{
			$ctrl.TotalReturnedQty = $ctrl.transactions.TotalReturnedQty;
		}
		
		//DELIVERED QTY
		if(delivered_qty >= 0){
			$ctrl.TotalDeliveredQty = $ctrl.transactions.TotalDeliveredQty+delivered_qty;
		}else{
			$ctrl.TotalDeliveredQty = $ctrl.transactions.TotalDeliveredQty;
		}
		

		$ctrl.CurrentQuantity = (((delivered_qty >= 0)?delivered_qty:0) + (((counted_qty >= 0)?counted_qty:parseInt($ctrl.data.Product.current_quantity))));
	}
	

	$ctrl.save = function () {
		var data = {'ProductTransaction':[{
						'product_id':$ctrl.data.Product.id,
						'name':$ctrl.name,
						'counted_qty': $ctrl.counted_qty,
						'returned_qty': $ctrl.returned_qty,
						'delivered_qty': $ctrl.delivered_qty,
						'purchase_price':$ctrl.purchase_price,
						'dr_no':$ctrl.dr_no,
						'date':$filter("date")($ctrl.dateNow, 'yyyy-MM-dd HH:mm:ss'),
					}],
					'Product':{
						'id':$ctrl.data.Product.id,
						'current_quantity':$ctrl.CurrentQuantity,
						'posted_quantity':($ctrl.data.Product.is_new == true)?$ctrl.CurrentQuantity:$ctrl.PostedQuantity,
						'is_new':false,
					},
					'ProductPricing':[{
						'id':$ctrl.ProductPriceId,
						'quantity':($ctrl.price_is_new == true)?$ctrl.delivered_qty:$ctrl.TotalDeliveredQty,
						'is_new':false,
					}]
				};
		
		$.ajax({
			method: 'POST',
			url: BASE_URL+'admin/product_transactions/add/',
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

