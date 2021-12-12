<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    
    $currentTime = date('Y-m-d H:i:s');

     // print_r($data);die();

    $userId = $data->userId;
    $postId = $data->postId;
   
   // checking for existing likes 
 
    $qr = mysqli_query($con, "SELECT * FROM `likes` WHERE `userId` = ".$userId." AND `postId` = ".$postId);

    if (mysqli_num_rows($qr) === 1) {  //if like found

       $qry_exec = mysqli_query($con, "DELETE FROM `likes` WHERE `userId` = ".$userId." AND `postId` = ".$postId); 


       if($qry_exec) {
           echo json_encode(array("status" => "remove", "message" => "Like Removed."));
       }
        else{
          echo json_encode(array("status" => "error", "message" => "Unable to remove like."));
       } 

    } else { // if like not found

        $qry = "INSERT INTO `likes` VALUES ('', ".$postId.", ".$userId.", '".$currentTime."')";
        $qry_exec = mysqli_query($con, $qry);

        if($qry_exec){
            echo json_encode(array("status" => "add", "message" => "Like Added."));
        }
         else{
            echo json_encode(array("status" => "error", "message" => "Unable to add like."));
        }

    }

?>