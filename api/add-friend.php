<?php

	include_once './config/database.php';
    include_once './config/auth-guard.php';

	$data = json_decode(file_get_contents("php://input"));

	 // print_r($data);die();
	$currentTime = date('Y-m-d H:i:s');

	$fromUserId = $data->fromUserId;
	$toUserId = $data->toUserId;
	
	// checking if friend request is already sent.

    $qr = mysqli_query($con, "SELECT * FROM `friends` WHERE (`fromUserId` = ".$fromUserId." AND `toUserId` = ".$toUserId.") OR (`toUserId` = ".$fromUserId." AND `fromUserId` = ".$toUserId.")");
    $qr_num = mysqli_num_rows($qr);

    if ($qr_num === 0 && ($fromUserId !== $toUserId)) {

    		$qry = "INSERT INTO `friends` VALUES ('', ".$fromUserId.", ".$toUserId.",'true', 'false', '".$currentTime."', ".$fromUserId.")";
			$qry_exec = mysqli_query($con, $qry);

			if($qry_exec){
	    		echo json_encode(array("status" =>"success", "message" => "Friend Request Sent."));
			}
			else{
	    		echo json_encode(array("status" =>"error", "message" => "Unable to add Friend."));
			}

    } else {
    	echo json_encode(array("status" =>"error", "message" => "Friend Request already send or error in request."));
    }

	
?>