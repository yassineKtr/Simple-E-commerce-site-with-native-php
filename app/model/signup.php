<?php 

    if(isset($_REQUEST['register'])){

        //fetching the info passed in the form

        $username = $_REQUEST['username'] ; 
        $mail = $_REQUEST['email'] ; 
        $pass = $_REQUEST['password'] ;
        $type = $_REQUEST['userType'] ;

        //setting up filters
        if(empty($username) || empty($mail) || empty($pass) || empty($type) ){
            header("location:?page=signup&error=emptyFields&uid=".$username."&mail=".$mail."&type=".$type);    //checking if a field is empty
            exit();

        }elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){   //checking if BOTH email and uid are invalid
            header("location:?page=signup&error=invalidMailUid");
            exit();

        }elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            header("location:?page=signup&error=invalidMail&uid=".$username);  //checking if email is valid
            exit();

        }elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("location:?page=signup&error=invalidUid&mail=".$mail);      //checking if uid is valid
            exit();

        }else{
            
            //including the file where we made the connection to the db
            require $config['DB_CONNECT_PATH'];

            //now every entry is valid

            $sql = "SELECT uidUser FROM users WHERE uidUser=?";  //preparing sql statement to avoid sql injection
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location:?page=signup&error=sqlError"); //in case failed to prepare stmt
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $username); 
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt); // storing the return value 

                $resultCheck = mysqli_stmt_num_rows($stmt);  // numbr of matchinf uid
                if($resultCheck > 0){
                    header("location:?page=signup&error=userTaken&mail=".$mail); // redirecting to page to change uid
                    exit();
                }else{
                    
                    //here we are going to repeat the same processe of running a sql command as we did before

                    $sql = "INSERT INTO users (uidUser,emailUsers,pwdUser,userType) VALUES (?,?,?,?) ";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("location:?page=signup&error=sqlError"); 
                        exit();
                    }else{

                        $hashedPwd = password_hash($pass, PASSWORD_DEFAULT); //hashing the password before inserting it in the db

                        mysqli_stmt_bind_param($stmt, "ssss", $username, $mail, $hashedPwd, $type); 
                        mysqli_stmt_execute($stmt);
                        header("location:?page=login&reg=success");   //sending the user back with a success message 
                        exit();
                    }


                }
                
            }

        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }