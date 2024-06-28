<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit</title>
</head>
<body>
    <script>
        window.location.href = "main.php"
    </script>
</body>
</html>

<?php
    //Adatbázisra rákapcsolódás
    include("database.php");
    //PHP Session indítása
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["wpmval"])) {
        try {
            $wpm = $_POST["wpmval"];
            $acc = $_POST["accval"];
            $currentDate = date("Y-m-d");
            //Az gépelés végett/idő lejártával új adatok feltöltése
            $sql = "INSERT INTO STATS(WPM,ACC,DATES,USER_ID) VALUES ($wpm,$acc,'$currentDate',".$_SESSION["userid"].");";
            mysqli_query($conn,$sql);
            //Kitöltött tesztek frissítése
            $sql = "SELECT * FROM STATS WHERE USER_ID = ".$_SESSION["userid"].";";
            $result = mysqli_query($conn, $sql);
            $_SESSION["testnum"] = mysqli_num_rows($result);
            //Legjobb WPM importálása
            $sql = "SELECT * FROM `stats` WHERE USER_ID = ".$_SESSION["userid"]." ORDER BY WPM DESC LIMIT 1;";
            $result = mysqli_query($conn, $sql);
            $res = mysqli_fetch_assoc($result);
            $_SESSION["bestwpm"] = $res["WPM"];
            //Legjobb Accuracy importálása
            $sql = "SELECT * FROM `stats` WHERE USER_ID = ".$_SESSION["userid"]." ORDER BY ACC DESC LIMIT 1;";
            $result = mysqli_query($conn, $sql);
            $res = mysqli_fetch_assoc($result);
            $_SESSION["bestacc"] = $res["ACC"];
            //WPM és Accuracy átlagának importálása
            $sql = "SELECT AVG(ACC),AVG(WPM) FROM `stats` WHERE USER_ID = ".$_SESSION["userid"].";";
            $result = mysqli_query($conn, $sql);
            $res = mysqli_fetch_assoc($result);
            $_SESSION["avgwpm"] = round($res["AVG(WPM)"]);
            $_SESSION["avgacc"] = round($res["AVG(ACC)"]);
            //Frissen gépelt eredmény importálása
            $sql = "SELECT * FROM STATS ORDER BY ID DESC;";
            $result = mysqli_query($conn,$sql);
            $res = mysqli_fetch_assoc($result);
            $_SESSION["curwpm"] = $res["WPM"];
            $_SESSION["curacc"] = $res["ACC"];
            mysqli_close($conn); 
        } catch(error){
            echo "Something went wrong";
        }
    }
?>