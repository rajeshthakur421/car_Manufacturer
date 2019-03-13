<?php
class Manufacturer
{
	var $host="localhost";
	var $user="rajesh";
	var $pass="root";
	var $db="car";
	public function connect()
	{
		$con=mysqli_connect($this->host,$this->user,$this->pass,$this->db); 
		return $con;
	}
	public function saveRecords($name)
	{
		$con=$this->connect();
		$query= "insert into Manufacturer(Name) values('$name')";
		mysqli_query($con,$query);
		return mysqli_affected_rows($con)?1:0;
	}
	public function modelRecords($modal,$quantity,$select){
		$con=$this->connect();
		$query= "insert into Model(Name,quantity,Manufacturer) values('$name','$quantity','$Manufacturer')";
		mysqli_query($con,$query);
		return mysqli_affected_rows($con)?1:0;
	}
	public function getData(){
		$con=$this->connect();
		$query = "SELECT id, Name FROM Manufacturer ORDER BY id DESC ;";
		$res = mysqli_query($con,$query);
		$data = array();
		while($row = mysqli_fetch_assoc($res)){
			array_push($data,$row);
		}
		return $data;
	}
}

class Modal
{
	var $host="localhost";
	var $user="rajesh";
	var $pass="root";
	var $db="car";
	public function connect()
	{
		$con=mysqli_connect($this->host,$this->user,$this->pass,$this->db); 
		return $con;
	}

	public function saveModal($modal,$quantity,$mid){
		$con=$this->connect();
		$query= "insert into Model(Name,quantity,mid) values('$modal','$quantity','$mid')";
		 
		mysqli_query($con,$query);
		return mysqli_affected_rows($con)?1:0;
	}
	public function getData(){
		$con=$this->connect();
		$query = "select b.id, b.name as Model, b.quantity, a.name from Manufacturer a , Model b where a.id=b.mid and quantity>0;";
		$res = mysqli_query($con,$query);
		$data = array();
		while($row = mysqli_fetch_assoc($res)){
			$id = $row [id];
		        $row['action'] = "<button ng-click='soldModel()'>Sold</button>";
			array_push($data,$row);
		}
		return $data;
	}
        public function sellModel($mid){
	   $con=$this->connect();
	   $query = "SELECT quantity FROM Model WHERE id='$mid';";
	   $res = mysqli_query($con,$query);
           $row = mysqli_fetch_assoc($res);
	   $quantity  = $row['quantity'];
	   if($quantity==1){
	   $query = "DELETE FROM Model WHERE id='$mid'";
	   }else{
		   $quantity-=1;
	   $query = "UPDATE Model SET quantity='$quantity' WHERE id='$mid'";
	   }
	   $res = mysqli_query($con,$query);
           return mysqli_affected_rows($con)?1:0;
	}
} 
$response = array();
if(isset($_REQUEST['manu_name'])){
	$name = $_REQUEST['manu_name'];
	$var = new Manufacturer();
	if($var->saveRecords($name)){
		$response[code]=1;
		$response[message]="Manufacturer data save successfully.";
	}else{
		$response[code]=-1;
		$response[message]="Error in saving data.";
	}
	echo json_encode($response);
}

if(isset($_REQUEST['get_manu'])){
        $var = new Manufacturer();
        $response[data] = $var->getData(); 
        echo json_encode($response);
}

if(isset($_REQUEST['add_modal'])){
	$name = $_REQUEST['name'];
	$quantity = $_REQUEST['quantity'];
	$brand = $_REQUEST['brand'];
	$model =  new Modal();
	if($model->saveModal($name,$quantity,$brand)){
		$response[code]=1;
		$response[message]="Modal data save successfully.";

	}else{
		$response[code]=-1;
		$response[message]="Error in saving data.";
	}

	echo json_encode($response);
}

if(isset($_REQUEST['get_model'])){       
	$var = new Modal();
        $response[data] = $var->getData();
        echo json_encode($response);
}
if(isset($_REQUEST['sell_model'])){
	$mid = $_REQUEST['mid'];
	$model = new Modal();
	if($model->sellModel($mid)){
		$response[code]=1;
		$response[message]="Modal sold successfully.";

	}else{
		$response[code]=0;
		$response[message]="Error in the process.";
	}

	echo json_encode($response);
}


?>
