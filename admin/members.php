<?php

/*
***********************
- Manage members page
- Add | edit | delete members here
****************
*/

session_start();
if(isset($_SESSION['Username'])){

    $pageTitle = 'Members';

    include 'init.php';
/** Begin Page Code */
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    if($do == 'Manage'){
       
    }elseif($do == 'Edit'){
        echo "Welcome Edit Page Your ID is".$_GET['userid'];
    }

/** End Page Code */

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}