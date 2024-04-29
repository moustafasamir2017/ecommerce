<?php

session_start();
if(isset($_SESSION['Username'])){

    $pageTitle = 'Dashboard';

    include 'init.php';

    /** Start Dashboard Page */ ?>

<div class="container home-stats text-center">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="stat">
                Total Members
                <span>200</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat">
                Total Pending Members
                <span>20</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat">
                Total Items
                <span>1500</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat">
                Total Comments
                <span>3500</span>
            </div>
        </div>
    </div>
</div>

<div class="container latest">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-users"></i> Latest Registered Users
                </div>
                <div class="card-body">Panel Content</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-tag"></i> Latest Items
                </div>
                <div class="card-body">Panel Content</div>
            </div>
        </div>
    </div>
</div>

 <?php   // echo "welcome " . $_SESSION['Username'];
    // print_r('<br>');
    // print_r($_SESSION);

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}