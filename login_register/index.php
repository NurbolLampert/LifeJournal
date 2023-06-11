<?php
    include '../login_register/usernavbar.php';
?>
<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Life Journal</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Life Journal</h1>
        <div class="content">
            <form action="index.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                Add notes:
                <textarea name="notes"></textarea>
                <input type="submit" value="Upload Image" name="submit">
                <a href="logout.php" class="btn btn-warning">Logout</a>
            </form>
            <a href="../login_register/view.php">View</a>
        </div>
        <?php
            $db = require_once "database.php";
            // obtaining the user by email
            $email = $_SESSION['email'];
            $query = "SELECT id FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $user_id = $row['id'];
            } else {
                // Query execution failed
                echo "Error: " . mysqli_error($connection);
            }
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                if($check !== false) {
                    // read the image data
                    $image = $_FILES['fileToUpload']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));

                    $notes = $_POST['notes'];
                    $dataTime = date("Y-m-d H:i:s");

                    if($db->connect_error){
                        die("Connection failed: " . $db->connect_error);
                    }

                    $stmt = $db->query("INSERT into user_images (user_id, image, created_date, notes) VALUES ('$user_id', '$imgContent', '$dataTime', '$notes')");

                    if($stmt){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "iss", $user_id, $image, $dataTime, $notes);
                        // Attempt to execute the prepared statement
                        echo "Success";
                        if(mysqli_stmt_execute($stmt)){
                            // Redirect to login page
                            header("location: index.php");
                        } else{
                            echo "Something went wrong. Please try again later.";
                        }
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                } else {
                    echo "File is not an image or is a raw image.";
                }
            }
            
        ?>


    </div>
</body>
</html>