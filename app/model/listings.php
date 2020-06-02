<?php
    require $config['DB_CONNECT_PATH'];

    $listingEmpty = true;
    //code for showing items
    $sql = "SELECT * FROM products WHERE ownerId=" . $userId . ";";  

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){
        $listingEmpty = false;
        $listing = [];
        $listingResult = [];
        while($row = mysqli_fetch_assoc($result)){

            $listing["prodId"] = $row['prodId'];
            $listing["prodName"] = $row['prodName'];
            $listing["prodDescription"] = $row['prodDescription'];
            $listing["prodPrice"] = $row['prodPrice'];
            $listing["pic"] = $row['pic'];
            $listing["categorie"] = $row['categorie'];
            
            
            array_push($listingResult,$listing);
        }
    }
    

    //handling delete request
    if(isset($_REQUEST['del'])){
        $prodId = get('del');
        $sql = "DELETE FROM products WHERE prodId=" . $prodId . ";";
        $result = mysqli_query($conn, $sql);
        
        unlink(fileWithExt($listing["pic"])); //delete old image
        header("location:?page=listings");

    }

    
    




    mysqli_close($conn);
