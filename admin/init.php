<?php

include 'connect.php';

// Routes

$tpl = 'includes/templates/';
$css = 'layout/css/';
$js = 'layout/js/';
$lang = 'includes/languages/';

// important files

include $lang.'english.php'; 
//include 'includes/languages/arabic.php'; 
include $tpl.'header.php'; 


// include navbar on all pages except some pages 
if(!isset($noNavbar)){ include $tpl.'navbar.php'; }


