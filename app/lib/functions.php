<?php   

    // getting the value of the parameter $name or returning by defaul the $def
    function get($name, $def = ''){

        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $def;

    }

    //error display function

    function displayError(){

        $error= get('error');

        if($error == 'emptyFields'){
            echo '
            <div class="alert alert-danger" role="alert">
            
                you left a field empty!
            </div>
            ';
        }elseif($error == 'sqlError'){
            echo '
            <div class="alert alert-danger" role="alert">
               there has been an error in the database!
            </div>
            ';

        }elseif($error == 'wrongPass' || $error == 'noUser'){
            echo '
            <div class="alert alert-danger" role="alert">
                user or password incorrect!
            </div>
            ';

        }elseif($error == 'invalidMailUid'){
            echo '
            <div class="alert alert-danger" role="alert">
               Invalid Mail and Uid!
            </div>
            ';

        }elseif($error == 'invalidMail'){
            echo '
            <div class="alert alert-danger" role="alert">
               Invalid Mail!
            </div>
            ';

        }elseif($error == 'invalidUid'){
            echo '
            <div class="alert alert-danger" role="alert">
               Invalid Uid!
            </div>
            ';

        }elseif($error == 'userTaken'){
            echo '
            <div class="alert alert-danger" role="alert">
               Username taken ...
            </div>
            ';

        }elseif($error == 'passNotMatch'){
            echo '
            <div class="alert alert-danger" role="alert">
               The passwords don\'t match ...
            </div>
            ';

        }elseif($error == 'fileExtNotSupp'){
            echo '
            <div class="alert alert-danger" role="alert">
               This file extension is not supported ...
            </div>
            ';

        }elseif($error == 'fileTooBig'){
            echo '
            <div class="alert alert-danger" role="alert">
               The file you\'ve entered is too big ...
            </div>
            ';

        }elseif($error == 'nolisting'){
            echo '
            <div class="alert alert-info" role="alert">
              no listing available ...
            </div>
            ';

        }


    }

    function activeCatg($catgName){
        if(get('categorie') == $catgName){
            return 'active';
        }
    }

    function categorieName($cat){
        switch($cat){
            case "IT":
                return "Telecommunications and Computing" ;
            break;

            case "CM":
                return "Chemicals and Materials" ;
            break;

            case "AT":
                return "Automotive and Transport" ;
            break;

            case "BF":
                return "Business and Finance" ;
            break;

            case "FB":
                return "Food and Beverage" ;
            break;

            case "E":
                return "Electronics" ;
            break;

            default:
                return $cat;

        }
    }

    function filterPrice($price){
        
            $twoDecNum = sprintf('%0.2f', round($price, 2));
        
        return $twoDecNum;
    }


    function fileWithExt($name){
        $exts = ['jpg','jpeg','png'];
        foreach($exts as $ext){
            $filename = 'prodImages/'.$name . '.' . $ext;
            if(file_exists($filename)){
                break;

            }
        }
        return $filename;
    }