(function (){
  'use strict';

  angular.module('AddressBook', []).controller('peopleController', peopleController);



function peopleController($scope){
  $scope.people =[];
  $scope.stored = localStorage.setItem('Stored',$scope.people);
  $scope.retrieved = localStorage.getItem('ret',$scope.stored); 
  console.log($scope.retrieved);
 
  $scope.Save = function() {
   $scope.people.push({
       name:$scope.neWpeople.name,
       phone:$scope.neWpeople.phone,
       city:$scope.neWpeople.city
   });

   $scope.formVisibility = false;
   };

   $scope.Showform = function(){
   	$scope.formVisibility = true;
   }

 }

 })();