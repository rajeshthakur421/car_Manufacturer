<!DOCTYPE html>
<html>
<head>
	<title>car</title>
	<script type="" src="js/angular.min.js"></script>

</head>
<body>
     <div ng-app="myApp" ng-controller="myCtrl">
           <h3>Add Manufacturer</h3>
           <form ng-model="form_manu" >
	       <span ng-model='form_msg'></span>	
               <input type="text" name="manufacturer" ng-model="manu" placeholder="manufacturer">                
           	   <button ng-click="addManu()">Add</button>
	   </form>
        <h3>Add modal and quantity</h3>
          <form >
               <input type="text" name="modal" ng-model="modal.name" placeholder="model name" required>
	       <input type="number" name="quantity" ng-model="modal.quantity" placeholder="quantity" required>
	       <select ng-model="modal.brand" required>
                   <option ng-repeat="option in manufacture" name="select" value="{{option.id}}">{{option.Name}}</option>
               </select>
                <button ng-click="addModal()">Add</button>
	   </form>

     <br>
<table>
<thead>
<tr><th>id</th><th>Manufacturer</th><th>Model</th><th>Quantity</th><th>Action</th></tr>
</thead>
<tbody>
<tr ng-repeat="m in model" ><td>{{m.id}}</td> <td>{{m.name}}</td> <td>{{m.Model}}  </td> <td> {{m.quantity}}</td> <td><button ng-click="soldModel(m.id)">Sold</button></td></tr>


</tbody>
</table>

</div>
      
<script>
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http, $sce) {
	$scope.deliberatelyTrustDangerousSnippet = function(data) {
               return $sce.trustAsHtml(data);
             };
$scope.manufacture ="";
	$http({
                method : "GET",
                        url : "service.php?get_manu=1"
        }).then(function mySuccess(response) {
                var response = response.data;
		$scope.manufacture = response.data;
		
        }, function myError(response) {
                // response.statusText;

	});

 $http({
                method : "GET",
                        url : "service.php?get_model=1"
        }).then(function mySuccess(response) {
                var response = response.data.data;
                $scope.model = response;
                console.log($scope.model);
        }, function myError(response) {
                // response.statusText;

        });
	$scope.soldModel = function(id){
		$http({
		method : "GET",
			url : "service.php?sell_model=1&mid="+id
	}).then(function mySuccess(response) {
		var response = response.data;
		if(response['code']==1){
		window.location.reload();
		}
		console.log(response);
	}, function myError(response) {
		// response.statusText;

	}); 
	}
$scope.addModal = function(){
	        var modal = $scope.modal;
		var data = "name="+modal.name+"&quantity="+modal.quantity+"&brand="+modal.brand;
	        console.log(data);	
		$http({
                method : "GET",
                        url : "service.php?add_modal=1&"+data
		}).then(function mySuccess(response) {
                alert(response.data.message) 
                    window.location.reload();
              
        }, function myError(response) {
                // response.statusText;

        });
	
	}	
	$scope.addManu = function(){

		$http({
		method : "GET",
			url : "service.php?manu_name="+$scope.manu
	}).then(function mySuccess(response) {
		var response = response.data;

		alert(response.message);
        window.location.reload();

	}, function myError(response) {
		// response.statusText;

	});   
	}
});
</script>
</body>

</html>
