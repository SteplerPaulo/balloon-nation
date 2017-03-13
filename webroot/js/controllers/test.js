App.controller('AdminProductsController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$rootScope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
			
		$http.get(BASE_URL+"products/all").success(function(response) {
			$scope.products = response;
			console.log(response);
		});
	}
	
	$rootScope.open = function (data,size, parentSelector) {
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
				controller: 'ModalInstanceCtrl',
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
	
	
});

App.controller('ModalInstanceCtrl', function ($rootScope,$uibModalInstance, ProductData,$filter,$http) {
	console.log(ProductData);
	var $ctrl = this;
	$ctrl.data = ProductData.Basic.data;
	$ctrl.transactions = ProductData.Transactions.response;
	$ctrl.dateNow = new Date($filter("date")(Date.now(), 'yyyy-MM-dd HH:mm:ss'));
	

	$ctrl.TotalRestockedQty =  $ctrl.transactions.TotalRestockedQty;
	$ctrl.TotalSold =  $ctrl.transactions.TotalSold;
	$ctrl.CurrentQuantity =  $ctrl.transactions.CurrentQuantity;
	
	$ctrl.toggleQty =  function(counted_qty,returned_qty,restocked_qty,sold){
		$ctrl.TotalReturnedQty = $ctrl.transactions.TotalReturnedQty+((returned_qty >= 0)?returned_qty:0);
		$ctrl.TotalRestockedQty = $ctrl.transactions.TotalRestockedQty+((restocked_qty >= 0)?restocked_qty:0);
		$ctrl.TotalSold = $ctrl.transactions.TotalSold+((sold >= 0)?sold:0);
		
		$ctrl.CurrentQuantity = (((restocked_qty >= 0)?restocked_qty:0) + $ctrl.transactions.CurrentQuantity)-(((sold >= 0)?sold:0)+((returned_qty >= 0)?returned_qty:0));
		$ctrl.MissingQuantity = ($ctrl.CurrentQuantity-counted_qty);
	}
	
	$ctrl.formula = false;
	$ctrl.toggleFormula =  function(data){
		console.log(data);
		switch(data){
			case "off":
				$ctrl.formula =  false;
				break;
			default:
				$ctrl.formula =  true;
				break;
		}
		
	}
	
	
	
	
	
	$ctrl.save = function () {
		var data = {'ProductTransaction':{
						'product_id':$ctrl.data.Product.id,
						'name':$ctrl.name,
						'restocked_qty': $ctrl.restocked_qty,
						'sold':$ctrl.sold,
						'date':$filter("date")($ctrl.dateNow, 'yyyy-MM-dd HH:mm:ss'),
						'last_date_posted':$ctrl.data.Product.last_date_posted,
						'posted_quantity':$ctrl.data.Product.posted_quantity,
					},
					'Product':{
						'id':$ctrl.data.Product.id,
						'current_quantity':$ctrl.CurrentQuantity,
					}
				};
		
		$.ajax({
			method: 'POST',
			url: BASE_URL+'admin/product_transactions/add/',
			dataType:'json',
			data: $.param({data:data}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function(response) {
			$uibModalInstance.close('');
			$rootScope.open($ctrl.data,'lg');
		});
	};
	
	
	$ctrl.close = function () {
		$rootScope.initializeController();
		$uibModalInstance.close('');
	};
});