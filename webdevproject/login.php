<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/x-icon" href="./keyboard_key_t.png">
</head>
<body>
    <div class="main">
        <form action="login.php" method="post">
            <input name="username" id="logintext" type="text" placeholder="username" required>
            <input name="pwd" id="pwd" type="password" placeholder="password" minlength="8" required>
            <button type="submit" id="submit">LOGIN</button>
            <p style="text-align: center;">Not registered? <a style="color: rgb(0, 190, 13);" href="signup.php">Create an account</a></p>
        </form>
    </div>
</body>
</html>
<?php
    session_start();

    include("database.php");
  
        if(isset($_POST["username"]) && isset($_POST["pwd"])){
            $username = $_POST["username"];
            $pwd = $_POST["pwd"];

            $pwd_check_q = "SELECT * FROM USERS WHERE USERNAME = '$username';";
            $pcqresult = mysqli_query($conn, $pwd_check_q);
            $pcqres = mysqli_fetch_assoc($pcqresult);
            //Account verifikáció
            if(mysqli_num_rows($pcqresult) > 0 && password_verify($pwd, $pcqres["PWD"])){
                $sql = "SELECT * FROM USERS WHERE USERNAME = '$username';";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    $_SESSION["username"] = $username;
                    $sql = "SELECT * FROM USERS WHERE USERNAME = '$username';";
                    $result = mysqli_query($conn,$sql);
                    $res = mysqli_fetch_assoc($result);
                    $_SESSION["userdate"] = $res["USER_DATE"];
                    $_SESSION["userid"] = $res["ID"];

                    header("Location: main.php");
        
                    $sql = "SELECT * FROM STATS WHERE USER_ID = ".$_SESSION["userid"].";";
                    $result = mysqli_query($conn, $sql);
                    $_SESSION["testnum"] = mysqli_num_rows($result);
                    if(mysqli_num_rows($result) > 0){
                        //WPM kimentése
                        $sql = "SELECT * FROM `stats` WHERE USER_ID = ".$_SESSION["userid"]." ORDER BY WPM DESC LIMIT 1;";
                        $result = mysqli_query($conn, $sql);
                        $res = mysqli_fetch_assoc($result);
                        $_SESSION["bestwpm"] = $res["WPM"];
                        //Accuracy kimentése
                        $sql = "SELECT * FROM `stats` WHERE USER_ID = ".$_SESSION["userid"]." ORDER BY ACC DESC LIMIT 1;";
                        $result = mysqli_query($conn, $sql);
                        $res = mysqli_fetch_assoc($result);
                        $_SESSION["bestacc"] = $res["ACC"];
                        //Átlag eredmények újraértékelése
                        $sql = "SELECT AVG(ACC),AVG(WPM) FROM `stats` WHERE USER_ID = ".$_SESSION["userid"].";";
                        $result = mysqli_query($conn, $sql);
                        $res = mysqli_fetch_assoc($result);
                        $_SESSION["avgwpm"] = round($res["AVG(WPM)"]);
                        $_SESSION["avgacc"] = round($res["AVG(ACC)"]);
                    }
                    else {
                        $_SESSION["bestwpm"] = 0;
                        $_SESSION["bestacc"] = 0;
                        $_SESSION["avgacc"] = 0;
                        $_SESSION["avgwpm"] = 0;
                    }

                    $_SESSION["curwpm"] = 0;
                    $_SESSION["curacc"] = 0;
                }
            }
            else {
                echo "Wrong username or password";
            }
            mysqli_close($conn);
        }
?>