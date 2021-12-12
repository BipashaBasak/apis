<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    $userId = $data->userId;

    $query = "
              SELECT 
                * 
              FROM 
                  `posts`, 
                  `users` 
              WHERE 
                   `posts`.`userId` = `users`.`id` AND 
                   `posts`.`userId` = '".$userId."' AND 
                   `posts`.`status` = 'active'";

    $qry_exec = mysqli_query($con, $query);

    $num = mysqli_num_rows($qry_exec);

    $posts = [];


    while ($row = mysqli_fetch_array($qry_exec)) {

        // print_r($row);
 
        $posts[] = array(
                     'id' => $row['id'], 
                     'user' => array(
                                    'userId'=>$row['userId'], 
                                    'name'=>$row['name'], 
                                    'email'=>$row['email'], 
                                    'gender'=>$row['gender'], 
                                    'city'=>$row['city']
                                ),
                     'content' => $row['content'], 
                     'createdBy' => $row['createdBy'], 
                     'createdAt' => $row['createdAt']
                 );

    }
   
    // die();       
     echo json_encode(
        array(
            "status" => "success",
            "data" => $posts
        )
        
    );
?>