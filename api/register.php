<?php
	include_once './config/database.php';

	$data = json_decode(file_get_contents("php://input"));

	 // print_r($data);die();

	$name = $data->name;
	$email = $data->email;
	$password = $data->password;
	$gender = $data->gender;
	$city = $data->city;

	if ($name && $email && $password && $gender) {

	    $qry = "INSERT INTO `users` VALUES ('', '".$name."', '".$email."','".$password."', '".$gender."', '".$city."', 'active')";
		$qry_exec = mysqli_query($con, $qry);

		if($qry_exec){
	    	echo json_encode(array("message" => "User successfully registered."));
		}
		else{
	    	echo json_encode(array("message" => "Unable to register the user."));
		}

	} else{
	    	echo json_encode(array("message" => "Invalid entry."));
	    	
	}

	
?>