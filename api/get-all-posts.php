<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $query = "
              SELECT 
                   `posts`.`id` AS `postId`, 
                   `posts`.`content` AS `content`, 
                   `posts`.`createdBy` AS `createdBy`, 
                   `posts`.`createdAt` AS `createdAt`,
                   `users`.`id` AS `userId`,
                   `users`.`name` AS `name`,
                   `users`.`email` AS `email`,
                   `users`.`gender` AS `gender`,
                   `users`.`city` AS `city`
              FROM 
                  `posts`, 
                  `users` 
              WHERE 
                   `posts`.`userId` = `users`.`id` AND   
                   `posts`.`status` = 'active'";

    $qry_exec = mysqli_query($con, $query);

    $num = mysqli_num_rows($qry_exec);

    $posts = [];


    while ($row = mysqli_fetch_array($qry_exec)) {

        // print_r($row);
 
        $posts[] =array(
                     'id' => $row['postId'], 
                     'user' => array(
                                    'userId'=>$row['userId'], 
                                    'name'=>$row['name'], 
                                    'email'=>$row['email'], 
                                    'gender'=>$row['gender'], 
                                    'city'=>$row['city']
                                ),
                     'content' => $row['content'], 
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