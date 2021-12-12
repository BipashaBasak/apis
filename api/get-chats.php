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
                      `messages`.`toUserId` 
                      FROM
                       `messages`
                      WHERE
                      `fromUserId` = ".$userId." ORDER BY `createdAt` ASC)";
                   

    $qry_exec = mysqli_query($con, $query);

    $chatUsers = [];

    while($row = mysqli_fetch_array($qry_exec)) {
        $chatUsers[] = array(
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
            "chatUsers" => $chatUsers
        )
        
    );
?>