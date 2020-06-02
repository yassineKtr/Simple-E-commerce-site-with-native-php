<?php
     session_unset(); //this line is to prevent user from geting back to the page after clicking back to the login screen 
    if(isset($_REQUEST['signup'])){
        header("location: ?page=signup");

    }elseif(isset($_REQUEST['login'])){

        require $config['DB_CONNECT_PATH'];

        $mailUid = $_REQUEST['mailUid']; //fetching data from form
        $pass = $_REQUEST['pass'];

        if(empty($mailUid) || empty($pass)){
            header("location:?page=login&error=emptyFields");
            exit();

        }else{
            $sql = "SELECT * FROM users WHERE uidUser=? OR emailUsers=?;";  // we are searching db by email AND user because we want to log in with either
            
            //same thing we did in signup...

            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location:?page=login&error=sqlError");
                exit();
            }else{
                
                mysqli_stmt_bind_param($stmt, "ss", $mailUid, $mailUid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($result)){        //if a result came back from the quere ie:the user exists , we associate at the same time his attributes to an array
                    $pwdCheck = password_verify($pass, $row['pwdUser']); //checking if the password is right

                    if($pwdCheck == false){
                        header("location:?page=login&error=wrongPass"); //wrong pass for that user
                        exit();
                    }elseif($pwdCheck == true){

                        //incase the infos are correct we are creating a session to store user infos
                        //and redirecting to the home page
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['userUid'] = $row['uidUser'];
                        $_SESSION['userType'] = $row['userType']; 
                        $_SESSION['cart']=array();

                        if($_SESSION['userType'] == "client"){
                            header("location:?page=home&user=" . $_SESSION['userType']);
                            exit();
                        }elseif($_SESSION['userType'] == "admin"){
                            header("location:?page=home&user=" . $_SESSION['userType']);
                            exit();
                        }
                        

                    }else{
                        header("location:?page=login&error=wrongPass"); //wrong pass for that user , this is just in case an error happens and the var is not bool
                        exit();
                    }

                }else{
                    header("location:?page=login&error=noUser"); //error the user doesnt exist
                    exit(); 
                }


            }
        }

    }