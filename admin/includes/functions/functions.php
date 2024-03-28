<?php
/*
** Title of the page if exist
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
** home redirect func [accept parameters]
** $errormsg = echo the error message
** $seconds = seconds before redirect
*/

function redirectHome($errorMsg,$seconds = 3){
    echo "<div class='alert alert-danger'>$errorMsg</div>";
    echo "<div class='alert alert-info'>You will be redirected to home after $seconds Seconds</div>";
    header("refresh:$seconds,url=index.php");
    exit();
}