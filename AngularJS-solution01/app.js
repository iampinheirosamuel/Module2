(function (){
	'use strict';

	angular.module('LunchChecker', [])
	.controller('LunchCheckerController', LunchCheckerController);
	LunchCheckerController.$inject['$scope'];

 function LunchCheckerController($scope){
  $scope.items =[];
  
  
 $scope.check=function(){
  // Collect "items" into the array itemvalue 
      var itemvalue = $scope.items;
  // Set a condition if user provided any itemvalue   
      $scope.$watch('$scope.items', function (){
       if($scope.items==0){
         $scope.message01 = "Please enter data first";
       }
      });
  // Listed items appended to a split method 
      var listed = itemvalue.split(',');
      $scope.num = listed.length;
      $scope.$watch('$scope.num', function (){
        if($scope.num>0 && $scope.num<4)
      {
          $scope.message02 = "Enjoy!";
        }
        else {
          $scope.message03 = "Too much!";
        } 
      });
       
};


 
 

/*$scope.message01 = function(){
      var message01 = "Plese enter data first";
      return message01;
    }
$scope.message02 = function(){
    var message02 = "Enjoy!";
    return message02;
   }
$scope.message03 = function(){
    var message03 = "Too much!";
    return message03;
   }*/

/*$scope.check= function(len) {
  $scope.message = { 
  
  };
   for (var i = 0; i < len.length; i++) {
    if (len==0) {
      document.write($scope.message01);
    }
    if (len>0 && len<4) {
      document.write($scope.message02);
    }
    if (len>3) {
      document.write($scope.message03);
    }
  }*/
  
  // // function calculatNum(totalNameValue.length) {
  //     var total = totalNameValue.length;
  //   return totalitems;
  // };

}
})();
