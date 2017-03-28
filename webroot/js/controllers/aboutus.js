App.controller('AboutUsController',function($scope,$rootScope,$http,$filter){
	
	
	$scope.initializeController = function(){
		$scope.Default = true; 
		$scope.VisionMission = false; 
		$scope.Accreditation = false; 
		$scope.Suppliers = false; 
		$scope.Customers = false; 
	}
	
	$scope.viewDefault = function (){
		$scope.Default = true; 
		$scope.VisionMission = false; 
		$scope.Accreditation = false; 
		$scope.Suppliers = false; 
		$scope.Customers = false; 
	}
	
	$scope.viewVisionMission = function (){
		$scope.Default = false; 
		$scope.VisionMission = true; 
		$scope.Accreditation = false; 
		$scope.Suppliers = false; 
		$scope.Customers = false; 
		window.scrollBy(0, -$(document).height() - $(window).height());
	}
	
	$scope.viewAccreditation = function (){
		$scope.Default = false; 
		$scope.VisionMission = false; 
		$scope.Accreditation = true; 
		$scope.Suppliers = false; 
		$scope.Customers = false; 
		window.scrollBy(0, -$(document).height() - $(window).height());
	}
	
	$scope.viewSuppliers = function (){
		$scope.Default = false; 
		$scope.VisionMission = false; 
		$scope.Accreditation = false; 
		$scope.Suppliers = true; 
		$scope.Customers = false; 
		window.scrollBy(0, -$(document).height() - $(window).height());
	}
	
	$scope.viewCustomers = function (){
		$scope.Default = false; 
		$scope.VisionMission = false; 
		$scope.Accreditation = false; 
		$scope.Suppliers = false; 
		$scope.Customers = true; 
		window.scrollBy(0, -$(document).height() - $(window).height());
	}
	
	
});