<?php

    //--------------db connection--------------

    //db params
    $serverName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName     = "mystore";

    //connection
    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);


    if(!$conn){
        die("connection failed: " .mysqli_connect_error());

    }