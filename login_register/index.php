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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/registration.css">
    <title>User Life Journal</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Life Journal</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
    <div class="content">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" class="form-control" name="uploadfile" value="">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="upload" >UPLOAD</button>
            </div>
        </form>
    </div>
</body>
</html>