<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    $postId = $data->postId;

    $query = "
            SELECT
                `users`.*,
                `likes`.`createdAt` AS `likeCreatedAt`
            FROM 
                `likes`, 
                `users` 
            WHERE 
                `likes`.`userId` = `users`.`id` AND
                `likes`.`postId` = ".$postId;

    $qry_exec = mysqli_query($con, $query);

    $num = mysqli_num_rows($qry_exec);

    $likes = [];
    while($row = mysqli_fetch_array($qry_exec)) {

        $likes[] = array(
            'createdAt'=>$row['likeCreatedAt'],
            'user'=>array(
                'userId'=>$row['id'], 
                'name'=>$row['name'], 
                'email'=>$row['email'], 
                'gender'=>$row['gender'], 
                'city'=>$row['city'], 
            )
        );

    }

    echo json_encode(
        array(
            
             "status" => "success",
             "data" => $likes
        )
    );
?> 