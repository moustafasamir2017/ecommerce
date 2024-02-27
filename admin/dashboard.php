<?php

session_start();
if(isset($_SESSION['Username'])){
    echo "welcome " . $_SESSION['Username'];
}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}