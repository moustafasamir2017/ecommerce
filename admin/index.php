<?php

session_start();
$noNavbar = '';
$pageTitle = 'Login';
if(isset($_SESSION['Username'])){
    header('Location: dashboard.php');
}

?>
<?php include "init.php"; ?>
<?php //include $tpl.'header.php'; ?>
<?php //include 'includes/languages/english.php'; ?>
<?php //include 'includes/languages/arabic.php'; ?>

<?php //echo lang('MESSAGE').' '.lang('ADMIN'); ?>

<?php  


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);

    // echo $username . ' - '.$hashedPass;

    $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1");
    $stmt->execute(array($username,$hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $_SESSION['Username'] = $username; // register session name
        $_SESSION['ID'] = $row['UserID']; // register session id
        header('Location: dashboard.php');
        exit();
        echo 'welcome '.$username;
    }
}

?>

<form class="login text-center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<h4>Admin Login</h4>
<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
<input class="btn btn-primary" type="submit" value="login">
</form>

<?php include $tpl.'footer.php'; ?>