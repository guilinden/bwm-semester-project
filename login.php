<?php 
include_once 'database/database.php';
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/teste.css">
</head>
<body>
	<div align="center" class="login">
		<form method="post">
			<br><br>
			<h1>Login</h1>
			<input type="text" name="user" class="email" placeholder="User"><br><br>
			<input type="password" name="password" class="email" placeholder="Password">
			<br><br><br><button type="submit" name="login" class="purchase">Login</button>
		</form>
	</div>




<?php 

if(isset($_POST['login'])){
	$user = $_POST['user'];
	$password = $_POST['password'];

	$connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
	mysql_select_db("bwm");

	$sql = "SELECT * FROM users WHERE user='$user' AND password='$password'";
	$result = mysql_query($sql);

	if(mysql_num_rows($result) == 0){
		echo"<script language='javascript' type='text/javascript'>alert('Username or password incorrect');</script>";
	}
	else{
		session_start();
		$_SESSION['user'] = $user;
		header("Location:admin.php");
	}
}	



 ?>


</body>
</html>