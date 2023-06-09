<?php
    include '..login_register/usernavbar.php';
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
            <div class="form-group">
                <input type="file" class="form-control" name="uploadfile" value="">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="upload" >UPLOAD</button>
            </div>
            </div>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
        </form>
        <?php
        session_start();

        // Connect to your database.
        $db = new PDO('mysql:host=localhost;dbname=your_db_name;charset=utf8mb4', 'db_user', 'db_pass');

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Try to upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                $userId = $_SESSION['user_id'];
                $notes = $_POST['notes'];
                // Prepare an insert statement
                $sql = "INSERT INTO user_images (user_id, image_path, notes) VALUES (?, ?, ?)";

                if($stmt = $db->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(1, $userId, PDO::PARAM_INT);
                    $stmt->bindParam(2, $target_file, PDO::PARAM_STR);
                    $stmt->bindParam(3, $notes, PDO::PARAM_STR);
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Redirect to login page
                        header("location: index.php");
                    } else{
                        echo "Something went wrong. Please try again later.";
                    }
                    // Close statement
                    unset($stmt);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        ?>
</body>
</html>