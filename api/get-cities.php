<?php
    include_once './config/database.php';
    

    $data = json_decode(file_get_contents("php://input"));


    $query = "
              SELECT 
                  *  
              FROM  
                  `cities` 
              WHERE 
                   `cities`.`status` = 'active'";

    $qry_exec = mysqli_query($con, $query);

    $cities = [];

    while($row = mysqli_fetch_array($qry_exec)) {
        $cities[] = array(
                     
                        'id'=>$row['id'], 
                        'name'=>$row['name']  
                 );

    }
      
    
     echo json_encode(
        array(
            "status" => "success",
            "data" => $cities
        )
        
    );
?>