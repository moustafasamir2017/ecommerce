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

        // Select all users except admin
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
        // excute statememnt
        $stmt->execute();
        // assign to variable
        $rows = $stmt->fetchAll();
        ?>
        <h1 class="text-center">Manage Members</h1>
        <div class="container">
            <a href='members.php?do=Add' class="btn btn-secondary mb-3"><i class="fa fa-plus"></i> New Member</a>
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registered Date</td>
                        <td>Control</td>
                    </tr>
                    <?php 
                        foreach($rows as $row){
                            echo "<tr>";
                                echo "<td>".$row['UserID']."</td>";
                                echo "<td>".$row['Username']."</td>";
                                echo "<td>".$row['Email']."</td>";
                                echo "<td>".$row['FullName']."</td>";
                                echo "<td>".$row['Date']."</td>";
                                echo "<td>
                                <a href='members.php?do=Edit&userid=".$row['UserID']."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                <a href='members.php?do=Delete&userid=".$row['UserID']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i> Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                    <!-- <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="#" class="btn btn-success">Edit</a>
                            <a href="#" class="btn btn-danger">Delete</a>
                        </td>
                    </tr> -->
                </table>
            </div>
        </div>

    <?php }elseif($do == 'Add'){ ?>

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

                    // check if user exist in database
                    $check = checkItem("Username","users",$user);

                    if($check == 1){

                        $theMsg = "<div class='alert alert-danger'>Sorry this usrer is exist</div>";
                        redirectHome($theMsg,'back');

                    }else{

                        // insert user info Database
                        $stmt = $con->prepare("INSERT INTO users(Username,Password,Email,FullName,Date) VALUES(:v_user,:v_pass,:v_mail,:v_name, now()) ");
                        $stmt->execute(array('v_user' => $user,'v_pass' => $hashPass,'v_mail' => $email,'v_name' => $name));

                        $theMsg = "<div class='alert alert-success'>".$stmt->rowCount(). ' - Recored Inserted' . "</div>";
                        redirectHome($theMsg,'back');

                    }


                }

            }else{
                //echo "You Can't view page directly";
                $theMsg = "<div class='alert alert-danger'>You Can't view page directly</div>";
                redirectHome($theMsg,'back');
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
                $theMsg = "<div class='alert alert-danger'>No Member Id Found</div>";
                redirectHome($theMsg,'back');
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
                $theMsg = "<div class='alert alert-success'>".$stmt->rowCount(). ' - Recored Updated' . "</div>";
                redirectHome($theMsg,'back');
            }

        }else{
                //echo "You Can't view page directly";
                $theMsg = "<div class='alert alert-danger'>You Can't view page directly</div>";
                redirectHome($theMsg);
        }

        echo "</div>";

    }elseif($do == 'Delete'){
        echo "<h1 class='text-center'>Update Member</h1>";
        echo "<div class='container'>";
            // check userId and is numeric
            $userid = isset($_GET['userid']) && is_numeric( $_GET['userid']) ? intval($_GET['userid']) : 0;
            // select data depend on id
            // old $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
            
            
            // excute query
            // old $stmt->execute(array($userid));
            // row count to check result
            // old $count = $stmt->rowCount();

            // new
            $check = checkItem('userid','users',$userid);
            // show for if id exist
            if($check > 0){
                $stmt = $con->prepare("DELETE FROM users WHERE UserID =:zuser");
                $stmt->bindParam(":zuser",$userid);
                $stmt->execute();
                $theMsg = "<div class='alert alert-success'>".$stmt->rowCount(). ' - Recored Deleted' . "</div>";
                redirectHome($theMsg,'back');
            }else{
                //echo "member with that id is not exist";
                $theMsg = "<div class='alert alert-danger'>member with that id is not exist</div>";
                redirectHome($theMsg);
            }
        echo "</div>";
    }

/** End Page Code */

    include $tpl.'footer.php';

}else{
    echo "you are not auth <br>";
    echo "<a href='/osama/ecommerce/admin/'>Login</a>";
}