<?php
    require_once "../db_connect.php";
    require_once "../file_upload.php";

    session_start();

    if(isset($_SESSION["user"])){
        header("Location: ../home.php");
    }

    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ../login.php");
    }
    $sqlAdm = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
    $resultAdm = mysqli_query($connect, $sqlAdm);
    $rowAdm = mysqli_fetch_assoc($resultAdm);

    $id = $_GET["x"];
    $sql = "SELECT * FROM animals WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $vacOptions = "";
    if($row["vaccinated"] == 0){
        $vacOptions .= "<option value='0' selected>No</option>";
        $vacOptions .= "<option value='1'>Yes</option>";
    }else {
        $vacOptions .= "<option value='0'>No</option>";
        $vacOptions .= "<option value='1'selected>Yes</option>";
    }

    $adpOptions = "";
    if($row["adopted"] == 0){
        $adpOptions .= "<option value='0' selected>No</option>";
        $adpOptions .= "<option value='1'>Yes</option>";
    }else {
        $adpOptions .= "<option value='0'>No</option>";
        $adpOptions .= "<option value='1'selected>Yes</option>";
    }

    if(isset($_POST["update"])){
        $name = $_POST["name"];
        $picture = fileUpload($_FILES["picture"], "animals");
        $location = $_POST["location"];
        $size = $_POST["size"];
        $age = $_POST["age"];
        $description = $_POST["description"];
        $gender = $_POST["gender"];
        $vaccinated = $_POST["vaccinated"];
        $adopted = $_POST["adopted"];

        if($_FILES["picture"]["error"] == 0){
            if($row["picture"] != "animal.png"){
                unlink("../../pictures/$row[picture]");
            }
            $sql = "UPDATE `animals` SET `name`='$name',`picture`='$picture[0]',`location`='$location',`size`='$size',`age`='$age',`description`='$description',`gender`='$gender',`vaccinated`='$vaccinated',`adopted`='$adopted' WHERE id = $id";
        }else {
            $sql = "UPDATE `animals` SET `name`='$name',`location`='$location',`size`='$size',`age`='$age',`description`='$description',`gender`='$gender',`vaccinated`='$vaccinated',`adopted`='$adopted' WHERE id = $id";
        }
        if(mysqli_query($connect, $sql)){
            echo "<div class='alert alert-success' role='alert'>
                    New record has been updated, {$picture[1]}
                </div>";
                header("refresh: 3; url = index.php");
        }else {
            echo "<div class='alert alert-danger' role='alert'>
                    error found, {$picture[1]}
                </div>";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../../css/base.css" rel="stylesheet">

</head>
<body>
   <nav class="navbar navbar-expand-lg bg-body-tertiary" >
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../../pictures/<?= $rowAdm["picture"] ?>" alt="user pic" width="30" height="24">
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                <li class="nav-item">
                    <a class="nav-link"href="../home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../update.php?id=<?= $rowAdm["id"] ?>">Edit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php" >Animals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create.php">Add Animal</a >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php?logout">Logout</a >
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5 editAnimal">
       <h2>Edit Animal</h2>
       <hr>
       <form method="POST" enctype="multipart/form-data">  
           <div class="mb-3 mt-3">
               <label for="name" class= "form-label">Name</label>
               <input  type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $row["name"] ?>">
            </div>
           <div class="mb-3">
                <label for="picture" class="form-label">picture</label>
                <input type = "file" class="form-control" id="picture" aria-describedby="picture" name="picture">
            </div>
           <div class="mb-3 mt-3">
               <label for="location" class= "form-label">Location</label>
               <input  type="text" class="form-control" id="location" aria-describedby="location" name="location" value="<?= $row["location"] ?>">
            </div>
           <div class="mb-3 mt-3">
               <label for="size" class= "form-label">Size</label>
               <input  type="text" class="form-control" id="size" aria-describedby="size" name="size" value="<?= $row["size"] ?>">
            </div>
           <div class="mb-3 mt-3">
               <label for="age" class= "form-label">Age</label>
               <input  type="text" class="form-control" id="age" aria-describedby="age" name="age" value="<?= $row["age"] ?>">
            </div>
           <div class="mb-3 mt-3">
               <label for="description" class= "form-label">Description</label>
               <textarea  type="text" class="form-control" id="description" name="description" cols="30" rows="3"> <?= $row["description"] ?></textarea>
            </div>
           <div class="mb-3 mt-3">
               <label for="gender" class= "form-label">Gender</label>
               <input  type="text" class="form-control" id="gender" aria-describedby="gender" name="gender" value="<?= $row["gender"] ?>">
            </div>
            Vaccinated: 
            <select id="vaccinated" name ="vaccinated"> 
              <?= $vacOptions ?>
            </select>
            <br>
            <br>
            Adopted: 
            <select id="adopted" name ="adopted"> 
              <?= $adpOptions ?>
            </select>
            <br>
            <hr>
            <button name="update" type="submit" class="btn btn-primary">Update animal</button>
            <a href="index.php" class="btn btn-warning">Back to home page</a>
        </form>
    </div>
    <footer>
        <nav class="IconNav">
            <a href="#"><img src="../../pictures/facebook.png"></a>
            <a href="#"><img src="../../pictures/google.png"></a>
            <a href="#"><img src="../../pictures/twitter.png"></a>
            <a href="#"><img src="../../pictures/instagram.png"></a>
            <a href="#"><img src="../../pictures/linkedin.png"></a>
            <a href="#"><img src="../../pictures/github.png"></a>
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