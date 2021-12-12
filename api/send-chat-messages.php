<?php

	include_once './config/database.php';
    include_once './config/auth-guard.php';

	$data = json_decode(file_get_contents("php://input"));

	 // print_r($data);die();
	$currentTime = date('Y-m-d H:i:s');

	$fromUserId = $data->fromUserId;
	$toUserId = $data->toUserId;
	$text = $data->text;

	$qry = "INSERT INTO `messages` VALUES ('', ".$fromUserId.", ".$toUserId.",'".$text."', '".$currentTime."', ".$fromUserId.")";
	$qry_exec = mysqli_query($con, $qry);

	if($qry_exec){
	    echo json_encode(array("status" =>"success", "message" => "Text Added."));
	}
	else{
	    echo json_encode(array("status" =>"error", "message" => "Unable to add text."));
	}
?>