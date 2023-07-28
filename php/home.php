<?php

    session_start();

    if(isset($_SESSION["adm"])){
        header("Location: dashboard.php");
    }

    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: login.php");
    }

    require_once "db_connect.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";

    $result = mysqli_query($connect, $sql);

    $row = mysqli_fetch_assoc($result);

    $sqlAnimals = "SELECT * FROM animals";
    $resultAnimals = mysqli_query($connect, $sqlAnimals);

    $layout = "";

    if(mysqli_num_rows($resultAnimals) > 0){
        while($rowAnimal = mysqli_fetch_assoc($resultAnimals)){
            $layout .= "<div class='mycard'>
            <div class='card' style='width: 18rem;'>
                <img src='../pictures/{$rowAnimal["picture"]}' class='card-img-top' alt='...'>
                <div class='card-body'>
                <h5 class='card-title'>{$rowAnimal["name"]}</h5>
                <hr>
                <p class='card-text'>Gender: {$rowAnimal["gender"]}</p>
                <hr>
                <p class='card-text'>Age: {$rowAnimal["age"]}</p>
                <hr>
                <p class='card-text'>{$rowAnimal["location"]}</p>
                <hr>
                <a href='animals/details.php?x={$rowAnimal["id"]}' class='btn btn-primary'>Details</a>
                </div>
                </div>
            </div>";
        }
    }else {
        $layout.= "No results found!";
    }

?>

<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta  name="viewport"  content="width=device-width, initial-scale=1.0" >
   <title>Welcome <?= $row["first_name"] ?></title>
    <link href ="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel= "stylesheet" integrity ="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"  crossorigin= "anonymous">
    <link href="../css/base.css" rel="stylesheet">

</head>
<body>
   <nav class="navbar navbar-expand-lg bg-body-tertiary" >
        <div class="container-fluid">
            <a class="navbar-brand" href="update.php?id=<?= $row["id"] ?>">
                <img src="../pictures/<?= $row["picture"] ?>" alt="user pic" width="30" height="24">
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" >Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="update.php?id=<?= $row["id"] ?>">Edit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php?logout">Logout</a >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="senior.php">Senior</a >
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
    <h2 class="text-center">Welcome <?= $row[ "first_name"] . " " . $row[ "last_name"] . "       (" .$row["email"] .")" ?></h2><span></span>
        <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $layout ?>
        </div>
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