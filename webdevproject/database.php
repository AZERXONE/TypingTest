<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pwd = "";
    $db_name = "typedb";
    $conn;

    try {
        $conn = mysqli_connect($db_server,$db_user,$db_pwd,$db_name);
    }
    catch(error){
        echo "error";
    }
?>