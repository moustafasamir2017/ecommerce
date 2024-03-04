<?php

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

// if(isset($_GET['do'])){
//     $do = $_GET['do'];
// }else{
//     $do = 'Manage';
// }

if($do == 'Manage'){
    echo "Welcome you are in manage category page";
    echo '<a href="page.php?do=Add"> Add New Category +</a>';
}elseif($do == 'Add'){
    echo "You are in Add";
}elseif($do == 'Insert'){
    echo "You are in Insert";
}else{
    echo "No page with this name"; 
}