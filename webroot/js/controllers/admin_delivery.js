App.controller('AdminForDeliveryController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		$scope.dateNow = new Date($filter("date")(Date.now(), 'yyyy-MM-dd HH:mm:ss'));
		$scope.check_all = false;
		
		$http.get(BASE_URL+"costumers/all").success(function(response) {
			$scope.costumers = response;
			if($scope.costumer ==  undefined){
				$scope.costumer = 'null';
			}
		});
	}
	
	
	$scope.changeCostumer = function (costumer) {
		$http.get(BASE_URL+"deliveries/costumer_product/"+costumer).success(function(response) {
			$scope.products = response.Products;
			$scope.costumer_address = response.Costumer.address;
			$scope.costumer_id = response.Costumer.id;
			console.log($scope.products);
		});		
	};
	
	$scope.check = function (i,is_checked) {
		if(is_checked){
			$scope.products[i].is_disabled = false;
		}else{
			$scope.products[i].is_disabled = true;
			$scope.check_all = false;
		}
		console.log($scope.products);
	};
	
	$scope.checkAll = function (is_checked) {
		if(is_checked){
			for (var i = 0; i < $scope.products.length; i++) {
				$scope.products[i].is_disabled = false;
				$scope.products[i].checkbox = true;
			}
		}else{
			for (var i = 0; i < $scope.products.length; i++) {
				$scope.products[i].is_disabled = true;
				$scope.products[i].checkbox = false;
			}
		}
		console.log($scope.products);
	};
	
	$scope.toggleQty = function(i,counted,bad_item,deliver){
		if(counted == undefined) counted=0;
		if(bad_item == undefined) bad_item=0;
		if(deliver == undefined) deliver=0;
		
		
		if(bad_item >= 0){
			$scope.products[i].UpdatedTotalReturned = $scope.products[i].TotalReturned+bad_item;
		}else{
			$scope.products[i].UpdatedTotalReturned = $scope.products[i].TotalReturned;
		}
		
		
		
		if(deliver >= 0){
			$scope.products[i].UpdatedTotalDelivered = $scope.products[i].TotalDelivered+deliver;
		}else{
			$scope.products[i].UpdatedTotalDelivered = $scope.products[i].TotalDelivered;
		}
		

		$scope.products[i].Product.current_quantity = counted+deliver-bad_item;
	}
	
	$scope.undoChanges = function(i){
		$scope.products[i].counted = undefined;
		$scope.products[i].bad_item = undefined;
		$scope.products[i].deliver = undefined;
		$scope.products[i].UpdatedTotalReturned = $scope.products[i].TotalReturned;
		$scope.products[i].UpdatedTotalDelivered = $scope.products[i].TotalDelivered;
		$scope.products[i].Product.current_quantity = $scope.products[i].cache_current_quantity;
	}
	
	$scope.save = function(){

		
		var dtls = [];
			dtls['Main'] = {};
			dtls['AssociatedProduct'] = {};
			dtls['AssociatedProductPrice'] = {};
			
			dtls['Main']['DeliveryDetail'] = {};
			dtls['Main']['Delivery'] = {'costumer_id':$scope.costumer_id,
										'delivery_receipt_no':$scope.dr_no,
										'date': $filter("date")($scope.dateNow, 'yyyy-MM-dd HH:mm:ss'),
										'stock_clerk': $scope.stock_clerk
									};
				
		for (var i = 0; i < $scope.products.length; i++) {
			
			if(!$scope.products[i].is_disabled){
				dtls['Main']['DeliveryDetail'][i] = {};
				dtls['Main']['DeliveryDetail'][i].product_id = $scope.products[i].Product.id;
				dtls['Main']['DeliveryDetail'][i].in_stock = $scope.products[i].counted;
				dtls['Main']['DeliveryDetail'][i].bad_item = $scope.products[i].bad_item;
				dtls['Main']['DeliveryDetail'][i].deliver = $scope.products[i].deliver;
				dtls['Main']['DeliveryDetail'][i].purchase_price = $scope.products[i].ProductPricing[0].purchase_price;
				
				dtls['AssociatedProduct'][i] = {};
				dtls['AssociatedProduct'][i]['Product'] = {};
				dtls['AssociatedProduct'][i]['Product'].id = $scope.products[i].Product.id;
				dtls['AssociatedProduct'][i]['Product'].current_quantity = $scope.products[i].Product.current_quantity;
				dtls['AssociatedProduct'][i]['Product'].posted_quantity = ($scope.products[i].Product.is_new == true)?$scope.products[i].Product.current_quantity:$scope.products[i].Product.posted_quantity;
				dtls['AssociatedProduct'][i]['Product'].is_new = false;
				
				
				dtls['AssociatedProductPrice'][i] = {};
				dtls['AssociatedProductPrice'][i]['ProductPricing'] = {};	
				dtls['AssociatedProductPrice'][i]['ProductPricing'].id = $scope.products[i].ProductPricing[0].id;
				dtls['AssociatedProductPrice'][i]['ProductPricing'].quantity = ($scope.products[i].ProductPricing[0].is_new == true)?$scope.products[i].deliver:$scope.products[i].UpdatedTotalDelivered,
				dtls['AssociatedProductPrice'][i]['ProductPricing'].is_new = false;
					
			}			
		}
		//return;
		
		var data = {
				'Main':dtls['Main'],
				'AssociatedProduct':dtls['AssociatedProduct'],
				'AssociatedProductPrice':dtls['AssociatedProductPrice'],
		};
	

		console.log(data);
		
		
		$.ajax({
			method: 'POST',
			url: BASE_URL+'admin/deliveries/add/',
			dataType:'json',
			data: $.param({data:data}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function(response) {
			//$scope.initializeController();
			window.location.href = BASE_URL+"admin/deliveries/";
		});
		
		
	}
	
});
