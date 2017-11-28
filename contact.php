<?php 
include_once 'database/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php'
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Contact</title>
	<link rel="stylesheet" href="css/teste.css">
</head>
<body>
	<div class="navbar">
 		<a href="index.php">Home</a>
  		<a href="store.php">Store</a>
 	 	<a href="aboutus.php">About us</a>
  		<a href="contact.php">Contact</a>
 	 	<a href="newsletter.php">NewsLetter</a>
	</div>
	<div class="buttonsCheckout">
		<div class="topCheckout">
			<h1>Contact us!</h1>
		</div>
		<form class="formPurchase" method="post" action="">
			<input type="text" name="firstName" class="email" placeholder="First Name">
			<br><br><input type="text" name="lastName" class="email" placeholder="Last Name">
			<br><br><input type="email" name="email" class="email" placeholder="Email">
			<h3>Write your message</h3>
			<textarea name="message"></textarea>   			
			<br><br><br><button type="submit" name="enviar" class="purchase">Send Message</button>
		</form>
	</div>

	<?php  
		if (isset($_POST['enviar'])) {
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$email = $_POST['email'];
			$message = $_POST['message'];

			$connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
			mysql_select_db("bwm");

			$bool = false;

			$sql = "INSERT INTO MESSAGES (firstname,lastname,email,message,alreadyread) VALUES ('$firstName','$lastName','$email','$message','$bool')";

			if(mysql_query($sql)){
				$mail = new PHPMailer();
				$mail->IsSMTP(true); 
				$mail->Host = "smtp.gmail.com";
				$mail->Port = 587;
				$mail->SMTPAuth = true; 
				$mail->SMTPSecure = 'tls';
				$mail->Username = 'username@domain.com';
				$mail->Password = 'password'; 
				$mail->setFrom('lindengui@gmail.com', 'BWM Team');
	    		$mail->addAddress('guilinden@tca.com.br', 'BWM TeamE'); 
				$mail->isHTML(true);
				$mail->Subject  = "Message confirmation BWM";
				$mail->Body = "We received your message and will be in touch soon<br><br>Thank you for your message :)";
				$mail->AltBody = "Order confirme";

				if (!$mail->send()) {
					echo"<script language='javascript' type='text/javascript'>alert('An error occurred');window.location.href='contact.php';</script>";
				} 
				else{
				    echo"<script language='javascript' type='text/javascript'>alert('Message sent, details were sent by 	email');window.location.href='contact.php';</script>";
				}
			}
		}

	?>

<footer id="main-footer" class="t-borer">
	<p>All rights reserved to <a class="footerLink" href="#">VIA University</a>.</p>
	<a class="footerLink" href="#top">Back to top &raquo;</a>
</footer>

<style type="text/css">
	textarea {
		width: 400px;
		height: 150px;
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