<?php

session_start();
if(isset($_SESSION['Username'])){

    $pageTitle = 'Dashboard';

    include 'init.php';

    // echo "welcome " . $_SESSION['Username'];
    // print_r('<br>');
    // print_r($_SESSION);

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}