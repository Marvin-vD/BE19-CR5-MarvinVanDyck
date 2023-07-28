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

    $result = mysqli_query($connect, "SELECT * FROM animals");
    
    $sqlAdm = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
    $resultAdm = mysqli_query($connect, $sqlAdm);
    $rowAdm = mysqli_fetch_assoc($resultAdm);

    if(isset($_POST["create"])){
        
        $name = $_POST["name"];
        $picture = fileUpload($_FILES["picture"], "animals");
        $location = $_POST["location"];
        $size = $_POST["size"];
        $age = $_POST["age"];
        $description = $_POST["description"];
        $vaccinated = $_POST["vaccinated"];
        $adopted = $_POST["adopted"];
        $gender = $_POST["gender"];

        $sql = "INSERT INTO `animals`( `name`, `picture`,`location`,`size`,`age`,`description`,`vaccinated`,`adopted`,`gender`) VALUES ('$name','$picture[0]','$location','$size','$age','$description','$vaccinated','$adopted','$gender')";

        if(mysqli_query($connect, $sql)){
            echo "<div class='alert alert-success' role='alert'>
                    New record has been created, {$picture[1]}
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
                    <a class="nav-link" href="index.php" >Animals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="create.php">Add Animal</a >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../update.php?id=<?= $rowAdm["id"] ?>">Edit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php?logout">Logout</a >
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5 editAnimal">
       <h2>Add new animal</h2>
       <hr>
       <form method="POST" enctype="multipart/form-data"> 
           <div class="mb-3 mt-3">
               <label for="name" class= "form-label">Name</label>
               <input  type="text" class="form-control" id="name" aria-describedby="name" name="name">
            </div>
           <div class="mb-3">
                <label for="picture" class="form-label">picture</label>
                <input type = "file" class="form-control" id="picture" aria-describedby="picture"   name="picture">
            </div>
           <div class="mb-3 mt-3">
               <label for="location" class= "form-label">Location</label>
               <input  type="text" class="form-control" id="location" aria-describedby="location" name="location">
            </div>
           <div class="mb-3 mt-3">
               <label for="size" class= "form-label">Size</label>
               <input  type="text" class="form-control" id="size" aria-describedby="size" name="size">
            </div>
           <div class="mb-3 mt-3">
               <label for="age" class= "form-label">Age</label>
               <input  type="text" class="form-control" id="age" aria-describedby="age" name="age">
            </div>
           <div class="mb-3 mt-3">
               <label for="description" class= "form-label">Description</label>
               <textarea  type="text" class="form-control" id="description" name="description" cols="30" rows="3"></textarea>
            </div>
            Vaccinated: 
            <select id="vaccinated" name ="vaccinated"> 
              <option value ="0" selected>No</option>
              <option value="1">Yes</option>
            </select>
            <br>
            <br>
            Adopted: 
            <select id="adopted" name ="adopted"> 
              <option value ="0" selected>No</option>
              <option value="1">Yes</option>
            </select>
            <br>
            <br>
            Gender: 
            <select id="gender" name ="gender"> 
              <option value ="Male">Male</option>
              <option value="Female" selected>Female</option>
              <option value="?">?</option>
            </select>
            <br>
            <hr>
            <button name="create" type="submit" class="btn btn-primary">Add animal</button>
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