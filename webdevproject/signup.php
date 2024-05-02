<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="icon" type="image/x-icon" href="./keyboard_key_t.png">
</head>
<body>
    <div class="main">
        <form action="signup.php" method="post">
            <input name="usernamee" id="logintext" type="text" placeholder="username" autocomplete="off" required>
            <input name="emaill" id="email" type="email" placeholder="email" autocomplete="off" required>
            <input name="pwdd" id="pwd" type="password" placeholder="password" autocomplete="off" minlength="8" required>
            <button type="submit" id="submit">Sign up</button>
        </form>

        <p style="text-align: center;">You already have an account? <a style="color: rgb(0, 190, 13);" href="login.php">Log in</a></p>
    </div>
</body>
</html>
<?php
    session_start();

    include("database.php");

    if(isset($_POST["usernamee"]) and isset($_POST["emaill"]) and isset($_POST["pwdd"])){
        $username = $_POST["usernamee"];
        $mail = $_POST["emaill"];
        $pwd = $_POST["pwdd"];
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $currentDate = date("Y-m-d");

        $sql = "SELECT * FROM USERS WHERE EMAIL = '$mail' OR USERNAME = '$username'";
        $result = mysqli_query($conn, $sql);

        $ssql = "SELECT * FROM USERS ORDER BY ID DESC";
        $rresult = mysqli_query($conn, $ssql);
        $rres = mysqli_fetch_assoc($rresult);
        

        if(mysqli_num_rows($result) < 1){
            $query = "INSERT INTO users(ID, USERNAME, EMAIL, PWD, USER_DATE) VALUES (".$rres["ID"]." + 1,'$username', '$mail', '$pwd','$currentDate');";
            mysqli_query($conn, $query);
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $mail;
            $_SESSION["pwd"] = $pwd;
            $sql = "SELECT USER_DATE FROM USERS WHERE USERNAME = '$username' AND PWD = '$pwd';";
            $result = mysqli_query($conn,$sql);
            $res = mysqli_fetch_assoc($result);
            $_SESSION["userdate"] = $res["USER_DATE"];
            $_SESSION["userid"] = $res["ID"];
            $_SESSION["testnum"] = 0;
            $_SESSION["bestwpm"] = 0;
            $_SESSION["bestacc"] = 0;
            $_SESSION["avgacc"] = 0;
            $_SESSION["avgwpm"] = 0;
            header("Location: login.php");
        }
        else {
            echo "Username or Email already in use!";
        }
        $sql = "SELECT * FROM DATES WHERE DATES = '$currentDate';";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) < 1){
            $query = "INSERT INTO DATES(DATES) VALUES ('$currentDate');";
            mysqli_query($conn, $query);
        }

        
        mysqli_close($conn);
    }

?>