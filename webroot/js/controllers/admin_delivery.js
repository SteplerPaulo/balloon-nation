App.controller('AdminForDeliveryController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		$scope.dateNow = new Date($filter("date")(Date.now(), 'yyyy-MM-dd HH:mm:ss'));
		$scope.check_all = false;
		$scope.view_all_items = true;
		$scope.selected_item_count = 0;
		$scope.preventDoubleClick = false;
		$scope.existingDRNo = false;
		
		$http.get(BASE_URL+"customers/all").success(function(response) {
			$scope.customers = response;
			if($scope.customer ==  undefined){
				$scope.customer = '';
			}
		});
	}
	
	
	$scope.changeCustomer = function (customer) {
		$http.get(BASE_URL+"deliveries/customer_product/"+customer).success(function(response) {
			$scope.products = response.Products;
			$scope.customer_address = response.Customer.address;
			$scope.customer_id = response.Customer.id;
		});		
	};
	
	$scope.check = function (i,is_checked) {
		if(is_checked){
			$scope.products[i].is_disabled = false;
			$scope.products[i].bad_item = 0;
			$scope.selected_item_count++;
		}else{
			$scope.products[i].is_disabled = true;
			$scope.products[i].bad_item = '';
			$scope.check_all = false;
			$scope.selected_item_count--;
		}
	};
	
	$scope.checkAll = function (is_checked) {
		if(is_checked){
			$scope.selected_item_count = 0;
			for (var i = 0; i < $scope.products.length; i++) {
				$scope.products[i].is_disabled = false;
				$scope.products[i].checkbox = true;
				$scope.products[i].bad_item = 0;
				$scope.selected_item_count++;
			}
		}else{
			for (var i = 0; i < $scope.products.length; i++) {
				$scope.products[i].is_disabled = true;
				$scope.products[i].checkbox = false;
				$scope.products[i].bad_item = '';
				$scope.selected_item_count--;
			}
		}
	};
	
	
	$scope.checkItem = function(item_code){
		
		for (var i = 0; i < $scope.products.length; i++) {
			if(item_code == $scope.products[i].Product.item_code){
				$scope.products[i].is_disabled = false;
				$scope.products[i].checkbox = true;
				$scope.products[i].bad_item = 0;
				$scope.selected_item_count++;
				return;
			}
		}
	}
	
	$scope.btnGrp = function(view_all_items,selected_item_only){
		$scope.view_all_items =  view_all_items;
		$scope.selected_item_only =  selected_item_only;
	}
	
	$scope.save = function(){
		$scope.preventDoubleClick = true;
		
		var dtls = [];
			dtls['Main'] = {};
			dtls['AssociatedProduct'] = {};
			
			dtls['Main']['DeliveryDetail'] = {};
			dtls['Main']['Delivery'] = {'customer_id':$scope.customer_id,
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
	
	$scope.checkDuplicate = function(dr_no){
		$http({
			method: 'POST',
			url: BASE_URL+'deliveries/check_duplicate',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:dr_no})
		}).then(function(result){
			console.log(result.data);
			if(result.data.length){
				$scope.existingDRNo = true;
				return;
			}
			$scope.existingDRNo = false;
		});
	}
	
});
