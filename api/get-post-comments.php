<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    $postId = $data->postId;

    $query = "
              SELECT 
                   `comments`.`id` AS `commentId`, 
                   `comments`.`content` AS `content`, 
                   `comments`.`createdBy` AS `createdBy`, 
                   `comments`.`createdAt` AS `createdAt`,
                   `users`.`id` AS `userId`,
                   `users`.`name` AS `name`,
                   `users`.`email` AS `email`,
                   `users`.`gender` AS `gender`,
                   `users`.`city` AS `city` 
              FROM 
                  `comments`, 
                  `users` 
              WHERE 
                   `comments`.`userId` = `users`.`id` AND 
                   `comments`.`postId` = '".$postId."' AND 
                   `comments`.`status` = 'active'";

    $qry_exec = mysqli_query($con, $query);

    $num = mysqli_num_rows($qry_exec);

    $comments = [];


    while ($row = mysqli_fetch_array($qry_exec)) {

        // print_r($row);
 
        $comments[] = array(
                     'id' => $row['commentId'], 
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
            "data" => $comments
        )
        
    );
?>