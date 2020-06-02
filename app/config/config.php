<?php

    $config = [
        'MODEL_PATH' => APPLICATION_PATH . DS . 'model' . DS,
        'VIEW_PATH' => APPLICATION_PATH . DS . 'view' . DS,
        'LIB_PATH' => APPLICATION_PATH . DS . 'lib' . DS,
        'DB_CONNECT_PATH' => APPLICATION_PATH . DS . 'config' . DS . 'dbConnect.php'
        

        

    ] ;

    
    require $config['LIB_PATH'] . 'functions.php';

    session_start();

    if(isset($_SESSION['userType']) && isset($_SESSION['userUid']) && isset($_SESSION['userId'])){
        $userType = $_SESSION['userType'];
        $userUid = $_SESSION['userUid'];
        $userId = $_SESSION['userId'];

    }