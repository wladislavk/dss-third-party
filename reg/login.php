<?php include 'includes/header.php'; ?>
<?php

if(isset($_POST['login']){
  $sql = "SELECT * FROM dental_patients 
	WHERE patientid='".mysql_real_escape_string($_POST['id'])."'
		AND lastname='".mysql_real_escape_string($_POST['lastname'])."'
		AND email='".mysql_real_escape_string($_POST['email'])."'";
  $q = mysql_query($sql); 
}

?>

<h2>Login</h2>

<form action="login.php" method="post">
<input type="hidden" name="id" value="<?= $_REQUEST['id']; ?>" />
<label>Last Name:</label><input type="text" name="lastname" /><br />
<label>Email:</label><input type="text" name="email" /><br />
<input type="submit" value="Login" />
</form>

<?php include 'includes/footer.php'; ?>
