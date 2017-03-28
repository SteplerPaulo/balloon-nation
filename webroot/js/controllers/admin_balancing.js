App.controller('AdminSemiMonthlyReportController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;
		$scope.is_posted = false;

		$http.get(BASE_URL+"sales/initial_data").success(function(response) {
			$scope.customers = response.Customers;
			if($scope.customer ==  undefined){
				$scope.customer = '';
			}
			$scope.inclusive_dates = response.InclusiveDates;
			
			if($scope.inclusive_date ==  undefined){
				$scope.inclusive_date = '';
			}
		});
	}

	$scope.changeFilter = function (customer, inclusive_month,inclusive_date) {
		if(	customer != undefined && inclusive_month != undefined && inclusive_date != undefined &&
			customer != '' && inclusive_month != '' && inclusive_date != ''
		){
			
			var data = {
				'customer_id':customer.Customer.id,
				'from':$filter('date')(inclusive_month, "yyyy-MM")+'-'+inclusive_date.InclusiveDate.from+' '+'00:00:00',
				'to':$filter('date')(inclusive_month, "yyyy-MM")+'-'+inclusive_date.InclusiveDate.to+' '+'23:59:59',
			};
			

			$http({
				method: 'POST',
				url: BASE_URL+'sales/get_data',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: $.param({data:data})
			}).then(function(response){
				$scope.data = response.data.Result;
				$scope.is_posted = response.data.is_posted;
				console.log($scope.data);
			});
			
			
		}
		
	};
	
	
	$scope.changeSold = function (i,o){
		//Compute missing quantity
		$scope.data[i].total_inventory = parseInt($scope.data[i].products.beginning_inventory)+parseInt($scope.data[i][0].total_delivered);
		
		if($scope.data[i][0].sold < $scope.data[i].total_inventory){
			$scope.data[i][0].in_stock =  $scope.data[i].total_inventory - $scope.data[i][0].sold;
			$scope.data[i][0].over_sold = 0;
		}else if($scope.data[i][0].sold > $scope.data[i].total_inventory){
			$scope.data[i][0].in_stock = 0;
			$scope.data[i][0].over_sold = $scope.data[i][0].sold - $scope.data[i].total_inventory;
		}else{
			$scope.data[i][0].in_stock = 0;
			$scope.data[i][0].over_sold = 0;
		
		}
		
	}
	
	
	$scope.save = function (){
		//console.log($scope.customer);
		//console.log($scope.inclusive_date);
		
		var data = {'Sale':{
						'customer_id':$scope.customer.Customer.id,
						'from_date':$filter('date')($scope.inclusive_month, "yyyy-MM")+'-'+$scope.inclusive_date.InclusiveDate.from,
						'to_date':$filter('date')($scope.inclusive_month, "yyyy-MM")+'-'+$scope.inclusive_date.InclusiveDate.to,
					}};
			data['SaleDetail'] = [];
			
		for (var i = 0; i < $scope.data.length; i++) {
			//console.log($scope.data[i]);
			data['SaleDetail'][i] = {
							'product_id':$scope.data[i].products.id,
							'delivered':$scope.data[i][0].total_delivered,
							'returned':$scope.data[i][0].total_returned,
							'sold':$scope.data[i][0].sold,
							'beginning_inventory':$scope.data[i].products.beginning_inventory,
						};
		}
		
			
		//console.log(data);	
		//return;
		$http({
			method: 'POST',
			url: BASE_URL+'admin/sales/add',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:data})
		}).then(function(response){
			window.location.href = BASE_URL+"admin/sales";
		});
		
		
	}
	
	
});


