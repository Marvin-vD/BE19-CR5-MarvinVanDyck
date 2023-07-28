<?php
    require_once "../db_connect.php";

    session_start();
    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ../login.php");
    }

    $sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
    $result = mysqli_query($connect, $sqlUser);
    $userRow = mysqli_fetch_assoc($result);

    $id = $_GET["x"];
    $sqlAnimal = "SELECT * FROM animals WHERE id = $id";
    $result = mysqli_query($connect, $sqlAnimal);
    $row = mysqli_fetch_assoc($result);

    $date = date('Y-m-d H:i:s');
    echo $date;
    echo $userRow["id"];
    echo $row["id"];

    $addAdoption = "INSERT INTO `pet_adoption`(`user_id`, `pet_id`, `adoption_date`) VALUES  ('$userRow[id]', '$row[id]', '$date')";
    if(mysqli_query($connect, $addAdoption)){
        echo "Success";
    }else {
         echo "Error";
    }
    $updateAdoptionStatus = "UPDATE `animals` SET `adopted`='1' WHERE id = $row[id]";
    if(mysqli_query($connect, $updateAdoptionStatus)){
        header( "Location: ../home.php");
    }else {
         echo "Error";
    }
?>