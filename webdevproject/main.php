<?php
    session_start();

    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMaster</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="icon" type="image/x-icon" href="./keyboard_key_t.png">
</head>
<body>
    <div class="first">
        <div class="navbar">
            <div class="navbar-left">
                <p>Type<span style="color: rgb(0, 190, 13);">Master</span></p>
            </div>
            <div class="navbar-right">
                <div class="account">
                    <img src="./user.jpg" alt="">
                    <?php
                        echo "<p>".$_SESSION["username"]."</p>"
                    ?>
                </div>
                <p class="statbutton" onclick="smoothscroll(1)">Stats</p>
                <p class="leadbutton" onclick="smoothscroll(2)">Leaderboard</p>
                <p><a class="logout" href="./login.php">Log out</a></p>
            </div>
        </div>
        <div class="options">
            <div class="timeoption">
                <p id="timer" style="font-size: 30px;">0</p>
            </div>
        </div>
        <div class="maintexts">
            <div class="texts">
                <p id="textt"></p>
            </div>
            <div class="userinput">
                <input id="user_input" type="text" placeholder="Type here" autocomplete="off">
            </div>
            <form id="wpmform" action="mainproc.php" method="post" class="wpmstats">
                <?php
                    echo "<p>WPM: ".$_SESSION["curwpm"]."</p>"
                ?>
                <input value="0" name="wpmval" id="wpm" type="text" readonly style="display: none;">
                <?php
                    echo "<p>Accuracy: ".$_SESSION["curacc"]."%</p>"
                ?>
                <input value="0" name="accval" id="acc" type="text" readonly style="display: none;">
                <button name="subbutton" id="sub" type="submit" style="display: none;"></button>
            </form>
        </div>
    </div>
    <div class="second" id="stats">
        <div class="acc">
            <div class="bx">
                <img src="./user.jpg" alt="">
                <?php
                    echo "<p>".$_SESSION["username"]."</p>"
                ?>
            </div>
            <div class="bx">
                <p style="color: rgb(0, 190, 13);">Joined:</p>
                <?php
                    echo "<p>".$_SESSION["userdate"]."</p>"
                ?>
            </div>
            <div class="bx">
                <p>Tests <span style="color: rgb(0, 190, 13);">completed:</span></p>
                <?php
                    echo $_SESSION["testnum"];
                ?>
            </div>
        </div>
        <div class="statsgrid">
            <div class="statbox">
                <p>Highest <span style="color: rgb(0, 190, 13);">wpm:</span></p>
                <?php
                    echo "<p>".$_SESSION["bestwpm"]."</p>"
                ?>
            </div>
            <div class="statbox">
                <p>Avarage <span style="color: rgb(0, 190, 13);">wpm:</span></p>
                <?php
                    echo "<p>".$_SESSION["avgwpm"]."</p>"
                ?>
            </div>
            <div class="statbox">
                <p>Highest <span style="color: rgb(0, 190, 13);">accuracy:</span></p>
                <?php
                    echo "<p>".$_SESSION["bestacc"]."%</p>"
                ?>
            </div>
            <div class="statbox">
                <p>Avarage <span style="color: rgb(0, 190, 13);">accuracy:</span></p>
                <?php
                    echo "<p>".$_SESSION["avgacc"]."%</p>"
                ?>
            </div>
        </div>
    </div>
    <div class="third" id="leader">
        <h1 style="padding-top: 50px;">Leader<span style="color: rgb(0, 190, 13);">board</span></h1>
        <div class="lb">
            <div class="lbcard">
                <?php
                    $sql = "SELECT USER_ID, MAX(WPM) FROM stats GROUP BY USER_ID ORDER BY MAX(WPM) DESC LIMIT 10";
                    $result = mysqli_query($conn, $sql);
                    $i = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        $query = "SELECT * FROM USERS WHERE ID = ".$row["USER_ID"].";";
                        $q = mysqli_query($conn,$query);
                        $qr = mysqli_fetch_assoc($q);
                        echo "<p>$i</p><p>".$qr["USERNAME"]."</p><p>WPM: ".$row["MAX(WPM)"]."</p>";
                        $i += 1;
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="./typeapp.js"></script>
    <script>
        function smoothscroll(num){
            try{
                if (num == 1){loc = "stats"}
                else {loc = "leader"}
                document.getElementById(loc).scrollIntoView({
                    behavior: "smooth"
                })
            }
            catch(error){
                alert(error)
            }
        }
    </script>
</body>
</html>
<?php
    
?>