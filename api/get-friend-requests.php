<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    $userId = $data->userId;

    $query = "
              SELECT 
                *
              FROM  
                  `users` 
              WHERE 
              `id` IN ( SELECT
                      `friends`.`fromUserId` 
                      FROM
                       `friends`
                      WHERE
                      `toUserId` = ".$userId." ORDER BY `createdAt` ASC)";
                   

    $qry_exec = mysqli_query($con, $query);

    $friendRequests = [];

    while($row = mysqli_fetch_array($qry_exec)) {
        $friendRequests[] = array(
                        'userId'=>$row['id'], 
                        'name'=>$row['name'], 
                        'email'=>$row['email'], 
                        'gender'=>$row['gender'], 
                        'city'=>$row['city']
                 );

    }
      
    
     echo json_encode(
        array(
            "status" => "success",
            "friendRequests" => $friendRequests
        )
        
    );
?>