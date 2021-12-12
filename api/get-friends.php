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
                    `id` IN (SELECT 
                                `userId` 
                             FROM (SELECT 
                                        `friends`.`fromUserId` AS `userId`, `createdAt` 
                                        FROM 
                                        `friends` 
                                        WHERE 
                                        `toUserId` = ".$userId." AND 
                                        `receiverStatus` = 'true'
                                   UNION
                                   SELECT 
                                   `friends`.`toUserId` AS `userId`, `createdAt` 
                                   FROM 
                                   `friends` 
                                   WHERE 
                                   `fromUserId` = ".$userId." AND     
                                   `receiverStatus` = 'true'
                                  ) a ORDER BY `createdAt` DESC
                             )";
                   

    $qry_exec = mysqli_query($con, $query);

    $friends = [];

    while($row = mysqli_fetch_array($qry_exec)) {
        $friends[] = array(
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
            "friends" => $friends
        )
        
    );
?>