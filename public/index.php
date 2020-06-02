<?php
    
    defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));
    const DS = DIRECTORY_SEPARATOR;

    require APPLICATION_PATH . DS . 'config' . DS . 'config.php' ; //requiring the config folder 
    
        $page = get('page','login'); // this var contains the page in action 
    
    //loading the path to the model and view of the current page 

    $model = $config['MODEL_PATH'] . $page . '.php'; 
    $view  = $config['VIEW_PATH'] . $page . '.phtml';
    $_404  = $config['VIEW_PATH'] . '404.phtml';        // path to the error page in case the model or view do not exist
    

    if(file_exists($model)){
        require $model;
    }

    $main_content = $_404;

    if(file_exists($view)){
        $main_content = $view;
    }

    include $main_content;      //loading the layout wich will contain the view of the page in action