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
	

	$ctrl.TotalAdded =  $ctrl.transactions.TotalAdded;
	$ctrl.TotalSubtracted =  $ctrl.transactions.TotalSubtracted;
	$ctrl.CurrentQuantity =  $ctrl.transactions.CurrentQuantity;
	
	$ctrl.toggleQty =  function(added,subtracted){
		$ctrl.TotalAdded = $ctrl.transactions.TotalAdded+((added >= 0)?added:0);
		$ctrl.TotalSubtracted = $ctrl.transactions.TotalSubtracted+((subtracted >= 0)?subtracted:0);
		
		$ctrl.CurrentQuantity = (((added >= 0)?added:0) + $ctrl.transactions.CurrentQuantity)-((subtracted >= 0)?subtracted:0);
		
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
						'added': $ctrl.added,
						'subtracted':$ctrl.subtracted,
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