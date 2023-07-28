<?php
    require_once "../db_connect.php";

    session_start();
    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ../login.php");
    }
    $id = $_GET["x"];

    $sql = "SELECT * FROM animals WHERE id = $id";
    $result = mysqli_query($connect, $sql);

    $row = mysqli_fetch_assoc($result);

    $editButton="";
    $takeHomeBtn ="<a href='adopt.php?x={$row["id"]}' class='btn btn-warning'>Take me home</a>";
    if(isset($_SESSION["user"])){
        $sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
    }
    elseif(isset($_SESSION["adm"])){
        $sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
        $editButton="<a href='update.php?x={$row["id"]}' class='btn btn-warning'>Edit</a>";
        $takeHomeBtn ="";
    }

    $result = mysqli_query($connect, $sqlUser);

    $userRow = mysqli_fetch_assoc($result);

    $id = $_GET["x"];

    $sql = "SELECT * FROM animals WHERE id = $id";
    $result = mysqli_query($connect, $sql);

    $row = mysqli_fetch_assoc($result);

    $vac = "";
    if($row["vaccinated"] == 0){
        $vac = "no";
    }
    else $vac = "yes";

    $ad = "";
    if($row["adopted"] == 0){
        $ad = "no";
    }
    else{
        $ad = "yes";
        $takeHomeBtn ="";
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
                <img src="../../pictures/<?= $userRow["picture"] ?>" alt="user pic" width="30" height="24">
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                <li class="nav-item">
                    <a class="nav-link"href="../home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../update.php?id=<?= $userRow["id"] ?>">edit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php?logout">Logout</a >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../senior.php">Senior</a >
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div>
            <h3><?= $row["name"] ?></h3>
            <p><img src="../../pictures/<?= $row["picture"] ?>" width="500"></p>
            <p>Location: <?= $row["location"] ?></p>
            <p>Size: <?= $row["size"] ?></p>
            <p>Age: <?= $row["age"] ?></p>
            <p>Gender: <?= $row["gender"] ?></p>
            <p>Vaccinated: <?= $vac ?></p>
            <p>adopted: <?= $ad ?></p>
            <hr>
            <p>description: <?= $row["description"] ?></p>
            <hr>
            <?= $takeHomeBtn ?>
            <?= $editButton ?>
            <!-- <a href='details.php?x={$row["id"]}' class='btn btn-primary'>Details</a> -->
        </div>   
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