<?php include 'includes/header.php'; ?>

<h2>Login</h2>

<form action="login.php" method="post">
<input type="hidden" name="id" value="<?= $_REQUEST['id']; ?>" />
<label>Last Name:</label><input type="text" name="lastname" /><br />
<label>Email:</label><input type="text" name="email" /><br />
<input type="submit" value="Login" />
</form>

<?php include 'includes/footer.php'; ?>
