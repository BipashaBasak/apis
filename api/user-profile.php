<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;

    $query = "SELECT * FROM `users` WHERE `id` = '".$id."'";
    $qry_exec = mysqli_query($con, $query);

    $num = mysqli_num_rows($qry_exec);


    $row = mysqli_fetch_array($qry_exec);
    $user = array(
                'id' => $row['id'], 
                'name' => $row['name'], 
                'email' => $row['email'], 
                'gender' => $row['gender'], 
                'city' => $row['city']);
           
     echo json_encode(
        array(
            "status" => "success",
            "data" => array(
                            'id' => $row['id'], 
                            'name' => $row['name'], 
                            'email' => $row['email'], 
                            'gender' => $row['gender'], 
                            'city' => $row['city'])
        )
        
    );

         // array('name' => $row['name'], 'email' => $row['email']);
    


    // echo json_encode(
    //     array(
    //         "status" => "success",
    //         "data" => $users
    //     )
    // );
?>