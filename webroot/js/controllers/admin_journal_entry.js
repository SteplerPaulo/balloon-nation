App.controller('AdminSemiMonthlyReportController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document,x2js){

	$scope.initializeController = function(){
		$scope.is_posted = false;
		$scope.view_all_items = true;
		$scope.concesLineItem = null;
		$scope.selected_item_count = 0;
		$scope.fileData = {};
		$scope.preventDoubleClick = false;
		
		$http.get(BASE_URL+"sales/initial_data").success(function(response) {
			$scope.customers = response.Customers;
			if($scope.customer ==  undefined){
				$scope.customer = '';
			}
		});
	}
	
	$scope.importXML = function (importedFile){
		var file_count = importedFile.length;
		$scope.fileData = {};
		$scope.hasProblem = false;
		$.each(importedFile, function(i, j){
			var reader = new FileReader();
            reader.onload = function(e) {
				var x2js = new X2JS();
				var xmlText = reader.result;
				var json = x2js.xml_str2json(xmlText);
				
				var splittedInfo = json.Conces.additionalInformation.split(":");
				var stNumIndex = splittedInfo.indexOf("stNum");
				var storeInfo = splittedInfo[stNumIndex+1];
				
				$scope.fileData['File'+(i+1)] = {
					'DocNo':json.Conces.concesId,
					'StoreNo':storeInfo.split(" ")[0],
					'StoreName':storeInfo.split(" ")[1],
					'SoldItems':json.Conces.concesLineItem
				};
				
				if(file_count == i+1) $scope.changeFilter($scope.customer,$scope.month_of);
				if(storeInfo.split(" ")[0] != $scope.customer.Customer.compcode) $scope.hasProblem = true;
			
			}
			reader.readAsText(importedFile[i]);
		});
	}
	
	$scope.changeFilter = function (customer, month) {
		if(	customer != undefined && month != undefined && customer != '' && month != ''){
			var lastDay = new Date($filter('date')(month, "yyyy"), parseInt($filter('date')(month, "MM")), 0);
			console.log(lastDay);
			
			var data = {
				'customer_id':customer.Customer.id,
				'customer_compcode':customer.Customer.compcode,
				'from_date':$filter('date')(month, "yyyy-MM")+'-01 00:00:00',
				'to_date':$filter('date')(month, "yyyy-MM")+'-'+$filter('date')(lastDay, "dd")+' 00:00:00',
				'doc_data':$scope.fileData,
			};
			
			$http({
				method: 'POST',
				url: BASE_URL+'sales/get_data',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: $.param({data:data})
			}).then(function(response){
				$scope.data = response.data.Result;
				$scope.is_posted = response.data.is_posted;
				$scope.selected_item_count = response.data.selected_items;
			});
		}
	};
	
	$scope.check = function (i,is_checked) {
		if(is_checked){
			$scope.data[i].is_readonly = false;
			$scope.data[i].bad_item = 0;
			$scope.data[i].ending_inventory = $scope.data[i].total_inventory-$scope.data[i].sold;
			
			$scope.selected_item_count++;
		}else{
			$scope.data[i].is_readonly = true;
			$scope.data[i].bad_item = '';
			$scope.data[i].ending_inventory = $scope.data[i].ending_inventory+$scope.data[i].sold;
			$scope.check_all = false;
			$scope.selected_item_count--;
		}
	};
	
	$scope.checkAll = function (is_checked) {
		if(is_checked){
			$scope.selected_item_count = 0;
			for (var i = 0; i < $scope.data.length; i++) {
				$scope.data[i].is_readonly = false;
				$scope.data[i].checkbox = true;
				$scope.data[i].bad_item = 0;
				$scope.selected_item_count++;
			}
		}else{
			for (var i = 0; i < $scope.data.length; i++) {
				$scope.data[i].is_readonly = true;
				$scope.data[i].checkbox = false;
				$scope.data[i].bad_item = '';
			}
			$scope.selected_item_count = 0;
		}
	};
	
	$scope.checkItem = function(item_code){
		for (var i = 0; i < $scope.data.length; i++) {
			console.log($scope.data[i].Product.item_code);
			if(item_code == $scope.data[i].Product.item_code && $scope.data[i].checkbox == false){
				console.log(item_code+' - '+$scope.data[i].Product.item_code);
				$scope.data[i].is_readonly = false;
				$scope.data[i].checkbox = true;
				$scope.data[i].bad_item = 0;
				$scope.selected_item_count++;
				return;
			}
		}
	}
	
	$scope.btnGrp = function(view_all_items,selected_item_only){
		$scope.view_all_items =  view_all_items;
		$scope.selected_item_only =  selected_item_only;
	}
	
	$scope.changeSold = function (i,o){
		//Compute missing quantity
		if($scope.data[i].sold < $scope.data[i].total_inventory){
			$scope.data[i].ending_inventory =  $scope.data[i].total_inventory - $scope.data[i].sold;
			$scope.data[i].over_sold = 0;
			return;
		}else if($scope.data[i].sold > $scope.data[i].total_inventory){
			$scope.data[i].ending_inventory = 0;
			$scope.data[i].over_sold = $scope.data[i].sold - $scope.data[i].total_inventory;
			return;
		}
		$scope.data[i].ending_inventory = 0;
		$scope.data[i].over_sold = 0;
		
		
		console.log($scope.data[i]);
	}
	
	$scope.save = function (){
		$scope.preventDoubleClick = true;
		
		var lastDay = new Date($filter('date')($scope.month_of, "yyyy"), parseInt($filter('date')($scope.month_of, "MM")), 0);
			
		var data = {'Sale':{
						'customer_id':$scope.customer.Customer.id,
						'from_date':$filter('date')($scope.month_of, "yyyy-MM")+'-01 00:00:00',
						'to_date':$filter('date')($scope.month_of, "yyyy-MM")+'-'+$filter('date')(lastDay, "dd")+' 00:00:00',
					}};
			data['SaleDetail'] = [];
			
		
			
		for (var i = 0; i < $scope.data.length; i++) {
			data['SaleDetail'][i] = {
							'product_id':$scope.data[i].Product.id,
							'delivered':$scope.data[i].delivered,
							'returned':$scope.data[i].returned,
							'sold':$scope.data[i].sold,
							'beginning_inventory':$scope.data[i].Product.beginning_inventory,
							'ending_inventory':$scope.data[i].ending_inventory,
							'over_sold':$scope.data[i].over_sold,
						};
		}
		
		$http({
			method: 'POST',
			url: BASE_URL+'admin/sales/add',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:data})
		}).then(function(response){
			console.log($scope.customer);
			window.location.href = BASE_URL+"admin/sales/index/"+$scope.customer.Customer.id+'/'+$scope.customer.Customer.name;
		});
	}
	
	
}).directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
				//console.log(changeEvent.target.files);
				scope.$apply(function () {
				     scope.fileread = changeEvent.target.files;
               });
            });
        }
    }
}]);


/*
.directive('fileInput', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attributes) {
            element.bind('change', function () {
                $parse(attributes.fileInput)
                .assign(scope,element[0].files)
                scope.$apply()
            });
        }
    };
}]).directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                scope.$apply(function () {
                    scope.fileread = changeEvent.target.files[0];
                    // or all selected files:
                    // scope.fileread = changeEvent.target.files;
                });
            });
        }
    }
}]);
*/



