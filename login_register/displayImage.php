<?php
include('database.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch image data
    $query = "SELECT image FROM user_images WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
        $imageData = $row['image'];

        // Send the correct headers
        header("Content-type: image/jpeg");

        // Output the image
        echo $imageData;
    }
}
?>
