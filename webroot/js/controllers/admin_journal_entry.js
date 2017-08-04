App.controller('AdminSemiMonthlyReportController',function($scope,$rootScope,$http,$filter,$uibModal, $log, $document,x2js){

	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 35;
		$scope.is_posted = false;
		$scope.view_all_items = true;
		

		$http.get(BASE_URL+"sales/initial_data").success(function(response) {
			$scope.customers = response.Customers;
			if($scope.customer ==  undefined){
				$scope.customer = '';
			}
		});
	}

	$scope.importXML = function (importedFile){
		//XML TO JSON
		var x2js = new X2JS();
		var xmlText = importedFile;
		$scope.fileData = x2js.xml_str2json( xmlText );	
		console.log($scope.fileData);


		//Document Info
		$scope.info = $scope.fileData.Conces;
		$scope.documentNo = $scope.info.concesId;

		//Document Additional Info
		var additionalInfo = $scope.fileData.Conces.additionalInformation;
		var splittedInfo = additionalInfo.split(":");
		var stNumIndex = splittedInfo.indexOf("stNum");
		var storeInfo = splittedInfo[stNumIndex+1];
		
		$scope.storeNo = storeInfo.split(" ")[0];
		$scope.storeName = storeInfo.split(" ")[1];
		
		$scope.docFilterValidation();
		

	}

	$scope.docFilterValidation = function () {
		console.log($scope.customer.Customer.compcode);
		if($scope.storeNo  != $scope.customer.Customer.compcode){
			alert('Document store no. is diferrent from costumer compcode');
		}
	}
	

	$scope.changeFilter = function (customer, month) {
	
		$scope.docFilterValidation();		

		if(	customer != undefined && month != undefined &&
			customer != '' && month != ''
		){
			var data = {
				'customer_id':customer.Customer.id,
				'customer_compcode':customer.Customer.compcode,
				'from_date':$filter('date')(month, "yyyy-MM")+'-01 00:00:00',
				'to_date':$filter('date')(month, "yyyy-MM")+'-31 00:00:00',
			};
			
			
			$http({
				method: 'POST',
				url: BASE_URL+'sales/get_data',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: $.param({data:data})
			}).then(function(response){
				$scope.data = response.data.Result;
				$scope.is_posted = response.data.is_posted;
				
			});
		
			
		}
		
	};
	
	$scope.check = function (i,is_checked) {
		if(is_checked){
			$scope.data[i].is_readonly = false;
			$scope.data[i].bad_item = 0;
			$scope.data[i].ending_inventory = $scope.data[i].ending_inventory-$scope.data[i].sold;
		}else{
			$scope.data[i].is_readonly = true;
			$scope.data[i].bad_item = '';
			$scope.data[i].ending_inventory = $scope.data[i].ending_inventory+$scope.data[i].sold;
			
			$scope.check_all = false;
		}
	};
	
	$scope.checkAll = function (is_checked) {
		if(is_checked){
			for (var i = 0; i < $scope.data.length; i++) {
				$scope.data[i].is_readonly = false;
				$scope.data[i].checkbox = true;
				$scope.data[i].bad_item = 0;
			}
		}else{
			for (var i = 0; i < $scope.data.length; i++) {
				$scope.data[i].is_readonly = true;
				$scope.data[i].checkbox = false;
				$scope.data[i].bad_item = '';
			}
		}
	};
	
	
	$scope.checkItem = function(item_code){
		
		for (var i = 0; i < $scope.data.length; i++) {
			if(item_code == $scope.data[i].Product.item_code){
				$scope.data[i].is_readonly = false;
				$scope.data[i].checkbox = true;
				$scope.data[i].bad_item = 0;
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
		}else if($scope.data[i].sold > $scope.data[i].total_inventory){
			$scope.data[i].ending_inventory = 0;
			$scope.data[i].over_sold = $scope.data[i].sold - $scope.data[i].total_inventory;
		}else{
			$scope.data[i].ending_inventory = 0;
			$scope.data[i].over_sold = 0;
		}
	}
	
	$scope.save = function (){
		//console.log($scope.customer);
		//console.log($scope.inclusive_date);
		
		var data = {'Sale':{
						'customer_id':$scope.customer.Customer.id,
						'from_date':$filter('date')($scope.month_of, "yyyy-MM")+'-01 00:00:00',
						'to_date':$filter('date')($scope.month_of, "yyyy-MM")+'-31 00:00:00',
					}};
			data['SaleDetail'] = [];
			
		for (var i = 0; i < $scope.data.length; i++) {
			//console.log($scope.data[i]);
			data['SaleDetail'][i] = {
							'product_id':$scope.data[i].Product.id,
							'delivered':$scope.data[i].delivered,
							'returned':$scope.data[i].returned,
							'sold':$scope.data[i].sold,
							'beginning_inventory':$scope.data[i].Product.beginning_inventory,
							'ending_inventory':$scope.data[i].ending_inventory,
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
	
	
}).directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsText(changeEvent.target.files[0]);
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



