App.controller('AdminForDeliveryController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		$scope.dateNow = new Date($filter("date")(Date.now(), 'yyyy-MM-dd HH:mm:ss'));
		$scope.check_all = false;
		
		$http.get(BASE_URL+"costumers/all").success(function(response) {
			$scope.costumers = response;
			if($scope.costumer ==  undefined){
				$scope.costumer = '';
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
	};
	


	$scope.save = function(){

		
		var dtls = [];
			dtls['Main'] = {};
			dtls['AssociatedProduct'] = {};
			
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
				dtls['Main']['DeliveryDetail'][i].bad_item = $scope.products[i].bad_item;
				dtls['Main']['DeliveryDetail'][i].deliver = $scope.products[i].deliver;
				dtls['Main']['DeliveryDetail'][i].purchase_price = $scope.products[i].Product.purchase_price;
				dtls['Main']['DeliveryDetail'][i].selling_price = $scope.products[i].Product.selling_price;
				dtls['Main']['DeliveryDetail'][i].date = $filter("date")($scope.dateNow, 'yyyy-MM-dd');	
			}			
		}
		var data = {
				'Main':dtls['Main'],
				'AssociatedProduct':dtls['AssociatedProduct'],
		};
		//	console.log(data);
		//return;

		
		$http({
			method: 'POST',
			url: BASE_URL+'admin/deliveries/add',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:data})
		}).then(function(response){
			window.location.href = BASE_URL+"admin/deliveries";
		});
		
	}
	
});
