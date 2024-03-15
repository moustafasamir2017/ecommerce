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
       echo "Members manage";
       echo "<br>";
       echo "<a href='members.php?do=Add'>Add New Member</a>";
    }elseif($do == 'Add'){ ?>

            <h1 class="text-center mt-5">Add New Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">
                    <!-- <input type="hidden" name="userid" value="<?= $userid; ?>" > -->
                    <div class="row g-3">
                        <div class="form-group form-group-lg">
                            <label class="form-label">Username</label>
                            <div class="col-sm-10 position-relative">
                                <input type="text" name="username" placeholder="Username to login to shop" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Password</label>
                            <div class="col-sm-10 position-relative">
                                <input type="password" name="password" placeholder="Password must be hard and complex"  class="form-control" autocomplete="new-password" required="required">
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Email</label>
                            <div class="col-sm-10 position-relative">
                                <input type="email" name="email" placeholder="Email must be valid" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Full Name</label>
                            <div class="col-sm-10 position-relative">
                                <input type="text" name="fullname" placeholder="Fullname appear in profile page" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Member" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

    <?php }elseif($do == 'Insert'){


            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo "<h1 class='text-center'>Insert Member</h1>";
                echo "<div class='container'>";

                // Get Variables from form
                $user = $_POST['username'];
                // for check pass empty or not
                $pass = $_POST['password'];
                $email = $_POST['email'];
                $name = $_POST['fullname'];

                // for insertion only
                $hashPass = sha1($_POST['password']);

                // validate the form
                $formErrors = array();
                if(empty($user)){
                    $formErrors[] = "username cannot be empty"; 
                    // echo "<div class='alert alert-danger'>username cannot be empty</div>";
                }
                if(strlen($user) < 4){
                    $formErrors[] = "username cannot be less than 4 char";
                }
                if(strlen($user) > 20){
                    $formErrors[] = "username cannot be more than 20 char";
                }
                if(empty($pass)){
                    $formErrors[] = "password cannot be empty";
                }
                if(empty($name)){
                    $formErrors[] = "name cannot be empty";
                }
                if(empty($email)){
                    $formErrors[] = "email cannot be empty";
                }
                foreach($formErrors as $error){
                    echo "<div class='alert alert-danger'>".$error."</div>";
                }

                // if no errors then process to update
                if(empty($formErrors)){
                    // insert user info Database
                    $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ? , Password = ? WHERE UserID = ?");
                    $stmt->execute(array($user,$email,$name,$pass,$id));

                    echo "<div class='alert alert-success'>".$stmt->rowCount(). ' - Recored Inserted' . "</div>";
                }

            }else{
                echo "You Can't view page directly";
            }

            echo "</div>";

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
                            <div class="col-sm-10 position-relative">
                                <input type="text" name="username" value="<?= $row['Username']; ?>" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Password</label>
                            <div class="col-sm-10 position-relative">
                                <input type="hidden" name="oldpassword" value="<?= $row['Password']; ?>">
                                <input type="password" name="newpassword" placeholder="Leave Blank If U Won't Change"  class="form-control" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Email</label>
                            <div class="col-sm-10 position-relative">
                                <input type="email" name="email" value="<?= $row['Email']; ?>" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="form-label">Full Name</label>
                            <div class="col-sm-10 position-relative">
                                <input type="text" name="fullname" value="<?= $row['FullName']; ?>" class="form-control" autocomplete="off" required="required">
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
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Get Variables from form
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['fullname'];

            // password trick

            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);  

            // validate the form
            $formErrors = array();
            if(empty($user)){
                $formErrors[] = "username cannot be empty"; 
                // echo "<div class='alert alert-danger'>username cannot be empty</div>";
            }
            if(strlen($user) < 4){
                $formErrors[] = "username cannot be less than 4 char";
            }
            if(strlen($user) > 20){
                $formErrors[] = "username cannot be more than 20 char";
            }
            if(empty($name)){
                $formErrors[] = "name cannot be empty";
            }
            if(empty($email)){
                $formErrors[] = "email cannot be empty";
            }
            foreach($formErrors as $error){
                echo "<div class='alert alert-danger'>".$error."</div>";
            }

            // if no errors then process to update
            if(empty($formErrors)){
                // Udate Database
                $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ? , Password = ? WHERE UserID = ?");
                $stmt->execute(array($user,$email,$name,$pass,$id));

                echo "<div class='alert alert-success'>".$stmt->rowCount(). ' - Recored Updated' . "</div>";
            }

        }else{
            echo "You Can't view page directly";
        }

        echo "</div>";

    }

/** End Page Code */

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}