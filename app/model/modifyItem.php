<?php

    require $config['DB_CONNECT_PATH'];

    
    
    $itemId = get('itemId');
    $itemPic = get('itemPic');

    //where we fetch the old data thats gonna be displayed to be updated
    $result = $conn->query("SELECT * FROM products WHERE prodId=$itemId") ;
    if($result){
        $row = $result->fetch_array();
        $prodName = $row['prodName'];
        $prodPrice = $row['prodPrice'];
        $prodDesc = $row['prodDescription'];

    }

    // this the part where the db is updated

    if(isset($_POST['update'])){
        
        //fetching the info passed in the form

        $prodName = $_REQUEST['prodName'] ; 
        $prodPrice = $_REQUEST['prodPrice'] ; 
        $prodDescription = $_REQUEST['Proddescription'] ;
        $prodPic = $_FILES['prodPic'] ;
        $prodCategorie =  $_REQUEST['categorie'] ;

        //setting up file parameters
        $fileName = $_FILES['prodPic']['name'];
        $fileSize = $_FILES['prodPic']['size'];
        $fileTmpLoc = $_FILES['prodPic']['tmp_name'];

        $fileExt = strtolower(end(explode('.', $fileName))); //getting the extention of the file
        $allowed = array('jpg', 'jpeg', 'png');
        $fileId =  uniqid('', true);
        $newFileName = $fileId . "." . $fileExt; //this is the name that will be stored in the DB
        //setting up filters
        if(!in_array($fileExt, $allowed)){
            if($fileSize > 1000000){
                header("location:?page=modifyItem&itemId=". $itemId ."&itemPic=".  $itemPic ."&error=fileTooBig");
                exit();
            }
            header("location:?page=modifyItem&itemId=". $itemId ."&itemPic=".  $itemPic ."&error=fileExtNotSupp");
            exit();

        }elseif(empty($prodName) || empty($prodPrice) || empty($prodDescription) || empty($prodPic) ||  $prodCategorie == "nothing"){
            header("location:?page=modifyItem&itemId=". $itemId ."&itemPic=".  $itemPic ."&error=emptyFields");    //checking if a field is empty
            exit();

        }else{
            //moving the pic to the prodPics file
            $fileDestination = 'prodImages' . DS . $newFileName;
            move_uploaded_file($fileTmpLoc, $fileDestination);
           
            unlink(fileWithExt($itemPic)); //deleting old image

            //now every entry is valid                   
                    //here we are going to repeat the same processe of running a sql command as we did before
                   
                    $sql = "UPDATE products SET prodName=?,prodPrice=?,prodDescription=?,pic=?,categorie=? WHERE prodId=?;";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("location:?page=modifyItem&itemId=". $itemId ."&itemPic=".  $itemPic ."&error=sqlError"); 
                        exit();
                    }else{ 
                        mysqli_stmt_bind_param($stmt, "ssssss", $prodName, $prodPrice, $prodDescription, $fileId, $prodCategorie, $itemId);
                        mysqli_stmt_execute($stmt);
                        header("location:?page=listings&reg=itemModifyed");   //sending the user back with a success message 
                        exit();
                    }


                
                   
            

        }
        
        mysqli_stmt_close($stmt);
        

    }




    mysqli_close($conn);



    



