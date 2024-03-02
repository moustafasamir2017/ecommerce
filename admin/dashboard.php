<?php

session_start();
if(isset($_SESSION['Username'])){
    include 'init.php';

    echo "welcome " . $_SESSION['Username'];

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}