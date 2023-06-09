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
        </div>
        <?php
            session_start();
            include('database.php');

            if(isset($_POST["submit"])) {
                $target_dir = "user_images/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                $check = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    // even if getimagesize() fails, we'll continue with the upload
                    // this is to allow for raw image files, which getimagesize() might not recognize
                    echo "File is not an image or is a raw image.";
                    $uploadOk = 1;
                }

                // Try to upload file
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    $userId = $_SESSION['user_id'];
                    $notes = $_POST['notes'];

                    // Prepare an insert statement
                    $stmt = mysqli_prepare($conn, "INSERT INTO user_images (user_id, image_path, notes) VALUES (?, ?, ?)");

                    if($stmt){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "iss", $userId, $target_file, $notes);
                        // Attempt to execute the prepared statement
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
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            ?>


    </div>
</body>
</html>