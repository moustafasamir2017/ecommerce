<?php include "init.php"; ?>
<?php include $tpl.'header.php'; ?>
<?php include 'includes/languages/english.php'; ?>
<?php //include 'includes/languages/arabic.php'; ?>

<?php //echo lang('MESSAGE').' '.lang('ADMIN'); ?>

<?php  

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);

    // echo $username . ' - '.$hashedPass;

    $stmt = $con->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
    $stmt->execute(array($username,$hashedPass));
    $count = $stmt->rowCount();
    if($count > 0){
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