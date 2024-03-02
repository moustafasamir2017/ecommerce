<?php

function lang($phrase){
    static $lang = array(
        // Dashboard strings
        'DASHBOARD_ADMIN' => 'Dashboard',
        'HOME_ADMIN' => 'Home',
        'CATEGORIES' => 'Categories',
    );
    return $lang[$phrase];
}