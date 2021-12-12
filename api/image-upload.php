<?php
    include_once './config/database.php';
    include_once './config/auth-guard.php';

    $data = json_decode(file_get_contents("php://input"), true); //collect input parameters and convert into readable format

     $fileName = $_FILES['sendimage']['name'];
     $tempPath = $_FILES['sendimage']['tmp_name'];
     $fileSize = $_FILES['sendimage']['size'];

    if(empty($fileName)) {
        $errorMSG = json_encode(array("message" => "Please select image", "status" => false));
        echo $errorMSG;
    } else {
        $upload_path = 'uploads/'; //set upload folder paths

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); //get image extension

        // valid image extension
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

        // allow valid image file formats 

        if(in_array($fileExt, $valid_extensions)) {

            // check file not exist our upload folder path 

            if(!file_exists($upload_path . $fileName)) {

                // check file size '5MB'

                if($fileSize < 5000000) {
                    move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path
                    echo $errorMSG = json_encode(array("message" => "Image Uploaded Successfully", "status" => true));
                } else {
                   $errorMSG = json_encode(array("message" => "Sorry, your file is too large, Please upload 5 MB size", "status" => false));
                   echo $errorMSG;
                }
            } else {
                $errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));
                 echo $errorMSG;
            }
        } else {
             $errorMSG = json_encode(array("message" => "Sorry,  only JPG, JPEG, PNG & GIF files are allowed", "status" => false));
                 echo $errorMSG;
        }

    }

    
?>