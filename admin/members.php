<?php

/*
***********************
- Manage members page
- Add | edit | delete members here
****************
*/

session_start();

$pageTitle = "Members";

if(isset($_SESSION['Username'])){

    $pageTitle = 'Members';

    include 'init.php';
/** Begin Page Code */
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    if($do == 'Manage'){
       
    }elseif($do == 'Edit'){ ?>

        <?php 
            // check userId and is numeric
            $userid = isset($_GET['userid']) && is_numeric( $_GET['userid']) ? intval($_GET['userid']) : 0;
            // select data depend on id
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
            // excute query
            $stmt->execute(array($userid));
            // fetch data
            $row = $stmt->fetch();
            // row count to check result
            $count = $stmt->rowCount();
            // show for if id exist
            if($count > 0){ ?> 
            <h1 class="text-center mt-5">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="userid" value="<?= $userid; ?>" >
                    <div class="row g-3">
                        <div class="form-group form-group-lg">
                            <label class="form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" value="<?= $row['Username']; ?>" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="oldpassword" value="<?= $row['Password']; ?>">
                                <input type="password" name="newpassword"  class="form-control" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="<?= $row['Email']; ?>" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="fullname" value="<?= $row['FullName']; ?>" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            <?php 
            // else if no id show error
            }else{
                echo "No Member Id Found";
            }
            ?>

    <?php }elseif($do == 'update'){

        echo "<h1 class='text-center'>Update Member</h1>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Get Variables from form
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['fullname'];

            // password trick

            if(empty($_POST['newpassword'])){
                $pass = $_POST['oldpassword'];
            }else{
                $pass = sha1($_POST['newpassword']);
            }

            // echo $id.' '.$user.' '.$email.' '.$name;
            // Udate Database
            $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ? , Password = ? WHERE UserID = ?");
            $stmt->execute(array($user,$email,$name,$pass,$id));

            echo $stmt->rowCount(). ' - Recored Updated';

        }else{
            echo "You Can't view page directly";
        }

    }

/** End Page Code */

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}