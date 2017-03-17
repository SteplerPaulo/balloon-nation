App.controller('AdminSemiMonthlyReportController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 7;

		$http.get(BASE_URL+"sales/initial_data").success(function(response) {
			$scope.costumers = response.Costumers;
			if($scope.costumer ==  undefined){
				$scope.costumer = '';
			}
			$scope.inclusive_dates = response.InclusiveDates;
			
			if($scope.inclusive_date ==  undefined){
				$scope.inclusive_date = '';
			}
		});
	}

	$scope.changeFilter = function (costumer, inclusive_month,inclusive_date) {
		if(	costumer != undefined && inclusive_month != undefined && inclusive_date != undefined &&
			costumer != '' && inclusive_month != '' && inclusive_date != ''
		){
			
			var data = {
				'costumer_id':costumer.Costumer.id,
				'from':$filter('date')(inclusive_month, "yyyy-MM")+'-'+inclusive_date.InclusiveDate.from+' '+'00:00:00',
				'to':$filter('date')(inclusive_month, "yyyy-MM")+'-'+inclusive_date.InclusiveDate.to+' '+'23:59:59',
			};
			

			$http({
				method: 'POST',
				url: BASE_URL+'sales/get_data',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: $.param({data:data})
			}).then(function(response){
				$scope.data = response.data;
				console.log($scope.data);
			});
			
			
		}
		
	};
	
	
	$scope.changeActualSale = function (i,o){
		//Compute missing quantity
		if($scope.data[i][0].actual < $scope.data[i][0].system_count){
			$scope.data[i][0].missing_qty = $scope.data[i][0].system_count - $scope.data[i][0].actual;
			$scope.data[i][0].over_sold = 0;
		}else if($scope.data[i][0].actual > $scope.data[i][0].system_count){
			$scope.data[i][0].missing_qty = 0;
			$scope.data[i][0].over_sold = $scope.data[i][0].actual - $scope.data[i][0].system_count;
		}else{
			$scope.data[i][0].missing_qty = 0;
			$scope.data[i][0].over_sold = 0;
		
		}
		
	}
	
	
	$scope.save = function (){
		//console.log($scope.costumer);
		//console.log($scope.inclusive_date);
		
		var data = {'Sale':{
						'costumer_id':$scope.costumer.Costumer.id,
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
							'system_count_sale':$scope.data[i][0].system_count,
							'actual_sale':$scope.data[i][0].actual,
							'missing_qty':$scope.data[i][0].missing_qty,
							'over_sold':$scope.data[i][0].over_sold,
						};
		}
		
			
		console.log(data);	
		return;
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


