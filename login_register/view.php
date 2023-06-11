<?php
    $db = require_once "database.php";
    if(!empty($_GET['user_id'])){
        $result = $db->query("SELECT image FROM user_images WHERE user_id = {$GET['user_id']}");

        if($result->num_rows > 0){
            $imgData = $result->mysqli_fetch_assoc();

            header("Content-type: image/jpg");
            echo $imgData['image'];
        } else{
            echo "Image not found...";
        }
    }
?>