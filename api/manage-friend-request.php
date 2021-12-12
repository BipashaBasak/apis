<?php

	include_once './config/database.php';
    include_once './config/auth-guard.php';

	$data = json_decode(file_get_contents("php://input"));

	 // print_r($data);die();
	// $currentTime = date('Y-m-d H:i:s');

	$fromUserId = $data->fromUserId;
	$toUserId = $data->toUserId;
	$acceptance = $data->acceptance;
	
	// checking if friend request exists.

    $qr = mysqli_query($con, "SELECT * FROM `friends` WHERE (`fromUserId` = ".$fromUserId." AND `toUserId` = ".$toUserId.") OR (`toUserId` = ".$fromUserId." AND `fromUserId` = ".$toUserId.")");
    $qr_num = mysqli_num_rows($qr);
    $fr_row = mysqli_fetch_array($qr);


    // if friend request exists.
    if ($qr_num !== 0 && ($fromUserId !== $toUserId)) {

    	if ($acceptance) {

    	  $qry = "UPDATE `friends` SET `receiverStatus` = 'true' WHERE `id` = ".$fr_row['id'];
		  $qry_exec = mysqli_query($con, $qry);

			if($qry_exec) {
	    		echo json_encode(array("status" =>"success", "message" => "Friend Request Accepted."));
			}
			else{
	    		echo json_encode(array("status" =>"error", "message" => "Unable to Accept Friend Request."));
			}	
    	} else {

    	  $qry = "DELETE FROM `friends` WHERE `id` = ".$fr_row['id'];
		  $qry_exec = mysqli_query($con, $qry);

			if($qry_exec) {
	    		echo json_encode(array("status" =>"rejected", "message" => "Friend Request Rejected."));
			}
			else{
	    		echo json_encode(array("status" =>"error", "message" => "Unable to Reject Friend Request."));
			}	
    	}

    } else {
    	echo json_encode(array("status" =>"error", "message" => "Friend Request doesn't exists."));
    }

	
?>