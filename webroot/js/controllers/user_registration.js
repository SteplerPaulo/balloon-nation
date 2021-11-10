App.controller('UserRegistrationController',function($scope,$rootScope,$http,$filter,$timeout,$window){
	$scope.initializeController = function(){
		$scope.currentPage = 1; 
		$scope.data = {}; 
		$scope.data.User = {}; 
		$scope.preventDoubleClick = false;
		$scope.demo = false;
		if($scope.demo){
			$scope.data.User.id = 2;
			$scope.data.User.first_name = 'Paulo';
			$scope.data.User.last_name = 'Biscocho';
			$scope.data.User.username = 'steplerpaulo';
			$scope.data.User.password = 'p@ssw0rd';
			$scope.data.User.confirm_password = 'p@ssw0rd';
		}
	}
	

	$scope.validateUsername = function(){
		console.log($scope.data.User.username);
		if($scope.data.User.username){
			var filter = {params: {'username': $scope.data.User.username }};
			$http.get(BASE_URL+"users/check",filter).success(function(response) {
				if(response.result){
					$scope.check = response; 
					console.log(response);
				}
				
			});
		}
		
	}

	$scope.register = function(){
		$scope.preventDoubleClick = true;
		$http({
			method: 'POST',
			url: '../users/register',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: $.param({data:$scope.data})
		}).then(function(response){
			$window.location.href = '../';
			$timeout(function(){
				$scope.preventDoubleClick = false;
			}, 1000);
		});
	}
});

/* App.directive('myDirective', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attr, mCtrl) {
		console.log(scope);
		console.log(element);
		console.log(attr);
		console.log(mCtrl); */
		
      /* function myValidation(value) {
        if (value.indexOf("e") > -1) {
          mCtrl.$setValidity('charE', true);
        } else {
          mCtrl.$setValidity('charE', false);
        }
        return value;
      }
      mCtrl.$parsers.push(myValidation); */
    // }
  // };
// });
/* 
App.directive('fileModel', ['$parse', function ($parse) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			var model = $parse(attrs.fileModel);
			var modelSetter = model.assign;

			element.bind('change', function(changeEvent) {
			
				scope.$apply(function() {
					modelSetter(scope, element[0].files);
				});
				//READ MULTIPLE FILES
				var fileList = element[0].files;
				for(var i=0; i < fileList.length; i++ ){
					setupReader(fileList[i],i);
				}
				
				//FILE READER
				function setupReader(file,i) {
					var reader = new FileReader();
					reader.onload = function(loadEvent) {  
						scope.$apply(function () {
							element[0].files[i].src = loadEvent.target.result;
							element[0].files[i].caption = '';
						});
					}
					reader.readAsDataURL(file);	
				}
			});
		}
	};
}]);
 */