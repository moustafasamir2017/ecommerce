<?php
session_start();
// start code...
session_unset();
// unset code...
session_destroy();
// destroy code...
header('Location: index.php');
// exit
exit();