<?php
/*
** Title of the page if exist v1
** default title if not exist
*/
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo "Default";
    }
}

/*
** home redirect func [accept parameters] v1
** $errormsg = echo the error message
** $seconds = seconds before redirect
*/

// function redirectHome($errorMsg,$seconds = 3){
//     echo "<div class='alert alert-danger'>$errorMsg</div>";
//     echo "<div class='alert alert-info'>You will be redirected to home after $seconds Seconds</div>";
//     header("refresh:$seconds,url=index.php");
//     exit();
// }

/*
** home redirect func [accept parameters] v2
** $theMsg = echo the message [error , success, warning]
** $url = the link to redirect
** $seconds = seconds before redirect
*/

function redirectHome($theMsg,$url = null,$seconds = 3){
    if($url == null){
        $url = 'index.php';
        $link = "Home Page";
    }else{
        //$url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php' ;
        if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
            $url = $_SERVER['HTTP_REFERER'];
            $link = "Previous Page";
        }else{
            $url = 'index.php';
            $link = "Home Page";
        }
    }
    echo $theMsg;
    echo "<div class='alert alert-info'>You will be redirected to $link after $seconds Seconds</div>";
    header("refresh:$seconds,url=$url");
    exit();
}


/*
** Check Items Function
** function check item in database v1
** $select - item to select [member , category , whatever]
** $from table to select from lik [members , categories]
** $value = the value of select
*/

function checkItem($select,$from,$value){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}

