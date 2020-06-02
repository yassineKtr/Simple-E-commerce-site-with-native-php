<?php
    require $config['DB_CONNECT_PATH'];
    $prodId = get('cartItem');
    
    //selecting everything about that item
    if(!empty($prodId)){
        $sql = "SELECT * FROM products WHERE prodId=" . $prodId . ";";  

        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
            
            $listing = [];
            while($row = mysqli_fetch_assoc($result)){

                $listing["prodId"] = $row['prodId'];
                $listing["prodName"] = $row['prodName'];
                $listing["prodDescription"] = $row['prodDescription'];
                $listing["prodPrice"] = $row['prodPrice'];
                $listing["pic"] = $row['pic'];
                $listing["categorie"] = $row['categorie'];
                
                //$listing array contains all the properties of that item
                
            }
        }
        array_push($_SESSION['cart'], $listing);
    }
    
    
    if(isset($_REQUEST['del'])){
        $itemToDel = get('del');

        foreach($_SESSION['cart'] as $item){
            if($item['prodId'] == $itemToDel){
                $key=array_search($item, $_SESSION['cart']);
                unset($_SESSION['cart'][$key]);

                header("location:?page=cart");
                exit();
            }
        }

       

    }

    
    

    
    




    mysqli_close($conn);

