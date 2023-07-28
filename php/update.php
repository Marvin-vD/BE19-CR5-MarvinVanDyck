<?php
   session_start();

   require_once  "db_connect.php";
   require_once  "file_upload.php";

   $id = $_GET["id"]; // taking the value of id from the URL

   $sql = "SELECT * FROM users WHERE id = $id";
   $result = mysqli_query($connect, $sql);

   $row = mysqli_fetch_assoc($result);

   $backBtn = "home.php";

   if( isset($_SESSION["adm"])){
       $backBtn = "dashboard.php";
   }

   if (isset($_POST["update"])){
       $fname = $_POST["fname"];
       $lname = $_POST["lname"];
       $email = $_POST["email"];
       $date_of_birth = $_POST["date_of_birth"];
       $picture = fileUpload($_FILES["picture"]);
       /* checking if a picture has been selected in the input for the image */
       if($_FILES["picture"]["error"] == 0){
            /* checking if the picture name of the product is not avatar.png to remove it from pictures folder */
            if($row["picture"] != "avatar.png"){
               unlink("pictures/$row[picture]" );
           }
           $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', picture = '$picture[0]', email = '$email' WHERE id = {$id}" ;
       } else {
           $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email' WHERE id = {$id}" ;
       }

    if (mysqli_query($connect, $sql)){
        echo  "<div class='alert alert-success' role='alert'>
       user has been updated, {$picture[1]}
     </div>" ;
     header( "refresh: 3; url=$backBtn" );
   } else  {
        echo   "<div class='alert alert-danger' role='alert'>
       error found, {$picture[1]}
     </div>" ;
   }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" >
        <title>Edit profile </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../css/base.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="update.php?id=<?= $row["id"] ?>">
                    <img src="../pictures/<?= $row["picture"] ?>" alt="user pic" width="30" height="24">
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                    <li class="nav-item">
                        <a class="nav-link"href="home.php" >Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="">Edit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php?logout">Logout</a >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="senior.php">Senior</a >
                     </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h1 class="text-center">Edit profile </h1>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3 mt-3" >
                    <label for="fname" class="form-label"> First name </label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?= $row["first_name"] ?> ">
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name </label>
                    <input type="text" class="form-control"   id="lname" name="lname" placeholder="Last name" value="<?= $row["last_name"] ?> ">
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Profile picture </label>
                    <input type="file" class="form-control" id="picture" name="picture">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control"   id="phone" name="phone" placeholder="Phone Number" value="<?= $row["phone_number"] ?> ">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control"   id="address" name="address" placeholder="Address" value="<?= $row["address"] ?> ">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $row["email"] ?> ">
                </div>
                <button name="update" type="submit" class="btn btn-primary" >Update profile </button>
                <a href="<?= $backBtn ?>" class="btn btn-warning" >Back</a>
            </form>
        </div>
    <footer>
        <nav class="IconNav">
            <a href="#"><img src="../pictures/facebook.png"></a>
            <a href="#"><img src="../pictures/google.png"></a>
            <a href="#"><img src="../pictures/twitter.png"></a>
            <a href="#"><img src="../pictures/instagram.png"></a>
            <a href="#"><img src="../pictures/linkedin.png"></a>
            <a href="#"><img src="../pictures/github.png"></a>
        </nav>
        <nav class="footerNav">
            <form>
                <label for="signUp">Sign up for our newsletter</label>
                <input type="text" name="signUp" id="signUp">
                <input type="subscripe" id="sub" value="Subscripe"> 
            </form>
        </nav>
        <p>&copy; 2023 Copyright: Marvin van Dyck</p>
    </footer>
     
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>