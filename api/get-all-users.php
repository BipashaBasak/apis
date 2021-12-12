<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    $userId = $data->userId;

    $query = "
              SELECT 
                `users`.`id` AS `userId`,
                `users`.`name` AS `name`,
                `users`.`email` AS `email`,
                `users`.`gender` AS `gender`,
                `users`.`city` AS `city`
              FROM  
                  `users` 
              WHERE 
                   `users`.`id` != ".$userId;

    $qry_exec = mysqli_query($con, $query);

    $users = [];

    while($row = mysqli_fetch_array($qry_exec)) {
        $users[] = array(
                     
                        'userId'=>$row['userId'], 
                        'name'=>$row['name'], 
                        'email'=>$row['email'], 
                        'gender'=>$row['gender'], 
                        'city'=>$row['city']
                 );

    }
      
    
     echo json_encode(
        array(
            "status" => "success",
            "data" => $users
        )
        
    );
?>