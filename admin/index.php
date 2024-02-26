<?php include "init.php"; ?>
<?php include $tpl.'header.php'; ?>
<?php include 'includes/languages/english.php'; ?>
<?php //include 'includes/languages/arabic.php'; ?>

<?php //echo lang('MESSAGE').' '.lang('ADMIN'); ?>


<form class="login text-center">
<h4>Admin Login</h4>
<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
<input class="btn btn-primary" type="submit" value="login">
</form>

<?php include $tpl.'footer.php'; ?>