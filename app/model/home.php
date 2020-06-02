<?php
    require $config['DB_CONNECT_PATH'];
    //----------------------------------------showing listings in home page----------------------------------//
    $emptylisting = true;
    if(isset($_POST['search']) && isset($_POST['searchContent'])){
        $searchCont = $_POST['searchContent'];
        $sql = "SELECT * FROM products WHERE prodName=" . '\''.$searchCont .'\''. ";"; //search bar content
    }elseif(isset($_REQUEST['categorie'])){
        $prodCat = get('categorie');
        
        $sql = "SELECT * FROM products WHERE categorie=" . '\''.$prodCat .'\''. ";"; //query where categorie is selected

    }else{
        $sql = "SELECT * FROM products ;" ;     //query where categorie is not selected
    }
    
    //loading the results
    $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
    
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){
        $emptylisting = false;
        $listing = [];
        $listingResult = [];
        while($row = mysqli_fetch_assoc($result)){

            $listing["prodId"] = $row['prodId'];
            $listing["prodName"] = $row['prodName'];
            $listing["prodDescription"] = $row['prodDescription'];
            $listing["prodPrice"] = $row['prodPrice'];
            $listing["pic"] = $row['pic'];
            $listing["categorie"] = $row['categorie'];
            $listing["ownerId"] = $row['ownerId'];
            
            
            array_push($listingResult,$listing);
        
        }
        
    }
    
    mysqli_close($conn);
    //--------------------------------------------------------------------------------------------------//
    
    

    

