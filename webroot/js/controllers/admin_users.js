App.controller('AdminUsersController',function($scope,$rootScope,$http,$filter){
	
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.pageSize = 10;
		
		
		$http.get(BASE_URL+"users/all").success(function(response) {
			$scope.users = response;
		});
	}
	
	$scope.addAsAdmin = function (data){
		$scope.UserId = data.User.id;
		$scope.ArosId = 2;//AROS ID FOR ADMIN GROUP
		
		
		$scope.ModalMessage = 'Assign '+data.User.full_name +' as admin?';
		$('#Modal').modal('show');
		
	}
	
	$scope.removeAsAdmin = function (data){
		$scope.UserId = data.User.id;
		$scope.ArosId = 3;//AROS ID FOR USER GROUP
		
		$scope.ModalMessage = 'Remove '+data.User.full_name +' as admin?';
		$('#Modal').modal('show');
	}
});