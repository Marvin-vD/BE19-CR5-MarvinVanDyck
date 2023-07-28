<?php
    session_start();
    require_once "db_connect.php";


    if(isset($_SESSION["adm"])){
        header("Location: dashboard.php");
    }

    if(isset($_SESSION["user"])){
        header("Location: home.php");
    }

    $email = $passError = $emailError = "";
    $error = false;

    function cleanInputs($input){
        $data = trim($input); // removing extra spaces, tabs, newlines out of the string
        $data = strip_tags($data); // removing tags from the string
        $data = htmlspecialchars($data); // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt";
 
         return $data;
    }

    if(isset($_POST["login"])){
        $email = cleanInputs($_POST["email"]);
        $password = $_POST["password"];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // if the provided text is not a format of an email, error will be true
            $error = true ;
            $emailError = "Please enter a valid email address" ;
        }
 
         // simple validation for the "password"
         if (empty ($password)) {
            $error = true ;
            $passError = "Password can't be empty!";
        }

        if(!$error){
            $password = hash("sha256", $password);

            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($result);
            
            if(mysqli_num_rows($result) == 1){
                if($row["status"] == "user"){
                    $_SESSION["user"] = $row["id"];
                    header("Location: home.php");
                }else {
                    $_SESSION["adm"] = $row["id"];
                    header("Location: dashboard.php");
                }
            }else {
                echo "<div class='alert alert-danger'>
                <p>Wrong credentials, please try again ...</p>
              </div>";
            }
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" >
        <title>Login page </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="../css/base.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Login page </h1>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>" >
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="text-danger"><?= $passError ?></span>
                </div>
                <button name="login" type="submit" class="btn btn-primary" >Login</button>
             
                <span>you don't have an account? <a href="register.php">register here </a></span>
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