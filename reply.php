<?php
	include_once 'database/database.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	session_start();

	if(isset($_SESSION['user'])){
		$id = session_id();
	}
	else {
		echo"<script language='javascript' type='text/javascript'>alert('You must be logged on. Permission denied');window.location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reply Message</title>
	<link rel="stylesheet" href="css/admin.css">
	 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<div align="center" class="tabela">
		<a href="admin.php" class="adminBtn">Admin Panel</a>
		<a href="logout.php" class="logout">Logout</a>
	</div>
	<div class="message" id="message">
	<?php
		$connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
		mysql_select_db("bwm");

		$page = !empty($_GET['message']) ? (int)$_GET['message'] : 1;
	  	$perPage = 1; //Set number of items per page
	  	$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;


		$bool = false;

		$sql = "SELECT * FROM MESSAGES WHERE ALREADYREAD = false LIMIT {$start},{$perPage}"; // SQL Query
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)){
		    Print '<h1>Name: ' . $row['FIRSTNAME'] . " " . $row['LASTNAME'] . '</h1>';
		    Print '<h2>Email: ' . $row['EMAIL'] . '</h2>';
		    Print '<h3>Message</h3>';
			Print '<p>' . $row['MESSAGE'] . '</p>';   
		}

	?>
	<h3>Reply</h3>
	<textarea></textarea>
	<br><button type="submit" name="enviar" class="reply">Reply</button>
	</div>

	<?php
		$mail = new PHPMailer();

		$mail->IsSMTP(true); 
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'tls';
		$mail->Username = 'username@domain.com';
		$mail->Password = 'password'; 
		$mail->setFrom('lindengui@gmail.com', 'BWM Team');
    	$mail->addAddress(''. $email, 'Guilherme Linden'); 
		$mail->isHTML(true);
		$mail->Subject  = "Order confirmation BWM";
		$mail->Body = "Order confirmed on the value of $" . $price . "<br>This is your order id: " . $id . "<br>Thank you for your order :)";
		$mail->AltBody = "Order confirmed on the value of $" . $price . "\r\n This is your order id: " . $id ."Thank you for your order! \r\n :)";

		if (!$mail->send()) {
			echo"<script language='javascript' type='text/javascript'>alert('An error occurred');window.location.href='index.php';</script>";
		} 
		else{
			echo"<script language='javascript' type='text/javascript'>alert('Purchase confirmed, details were sent by 	email');window.location.href='index.php';</script>";
		}

	?>

<style type="text/css">
	textarea {
		width: 80%;
		height: 250px;
		box-sizing: border-box;
		background-color: #f8f8f8;
		font-size: 16px;
		resize: none;
		border-width:2px; 
		border-style:solid; 
		padding:8px; 
		font-size:15px; 
		border-radius:12px; 
		border-color:#ffecc7; 
	}

	textarea:focus { 
		outline:none; 
	} 
</style>
</body>
</html>