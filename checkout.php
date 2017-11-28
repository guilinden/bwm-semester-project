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
	<title>Checkout</title>
	<link rel="stylesheet" href="css/teste.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<div class="navbar">
 	<a href="index.php">Home</a>
  	<a href="store.php">Store</a>
 	 <a href="aboutus.php">About us</a>
  	<a href="contact.php">Contact</a>
 	 <a href="newsletter.php">NewsLetter</a>
	</div>
	<div class="topCheckout">
		<h1>Checkout</h1>
	</div>
	<div class="buttonsCheckout">
		<a href="#" class="btn">Paypal</a>
		<a href="#" class="btnBitcoin">Bitcoin</a>
		<h2 class="price" id="price">Total Price </h2>
		<form class="formPurchase" method="post" action="">
			<input type="text" name="cardNumber" class="cardNumber" placeholder="Card Number">
			<input type="text" name="cardCVC" class="cardCCV" placeholder="CVC">
			<br><br><input type="text" name="cardName" class="cardName" placeholder="Full name">
			<input type="text" name="cardYear" class="cardYear" placeholder="MM">
			<input type="text" name="cardMonth" class="cardMonth" placeholder="YY">
			<br><br><input type="email" name="email" class="email" placeholder="Email">
		
		<h2>Shipping address</h2>
		<input type="text" name="address" class="email" placeholder="Full address">
		<br><br><br><button type="submit" name="enviar" class="purchase">Purchase</button>
		</form>
	</div>

<script>
	var header = location.search.split("=");
	var totalPrice = header[1];
	var price = document.getElementById("price");
	price.innerHTML = "Total Price $"+totalPrice; 
</script>

<?php
	if(isset($_POST['enviar'])){
		
		$price = $_GET['value'];
		$address = $_POST['address'];
		$cardNumber = $_POST['cardNumber'];
		$cardCVC = $_POST['cardCVC'];
		$cardName = $_POST['cardName'];
		$cardYear = $_POST['cardYear'];
		$cardMonth = $_POST['cardMonth'];
		$email = $_POST['email'];

		// Required field names
		$required = array('cardNumber', 'cardCVC', 'cardName', 'cardYear', 'cardMonth', 'email');
		$error = false;
		$errorMessage = "";
		foreach($required as $field) {
  			if (empty($_POST[$field])) {
    		$error = true;
  			}
		}

		if ($error) {
  			echo"<script language='javascript' type='text/javascript'>alert('All fields are required');</script>"; 
		} 		
		else {

			if(strlen($cardNumber) > 12 ){
				$errorMessage = "Card number must be up to 12 digits";
			}

			$cardMonthInt = (int)$cardMonth;

			//if(strlen($cardMonth) > 2 || $cardMonthInt > 12){
			//	$errorMessage = "Card month is not valid";
			//}

			$currentYear = (int)substr(date("Y"), -2);
			$year = (int)$cardYear;	

			//if(strlen($cardYear) > 2 || $year < $currentYear){
			//	$errorMessage = "Card year is not valid" . $currentYear . " ";
			//}

			if(strlen($cardCVC) != 3){
				$errorMessage = "Card CVC must have to 3 digits";
			}

			if($errorMessage != ""){
				echo"<script language='javascript' type='text/javascript'>alert('" . $errorMessage ."');</script>"; 
			}
			else{

				$connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
				mysql_select_db("bwm");

				$id  = substr(md5(microtime()*rand(0,9999)),0,10);

				$sql = "INSERT INTO orders (fullname,cardnum,yy,mm,cvc,email,price,orderid,address) VALUES ('$cardName','$cardNumber','$cardYear','$cardMonth','$cardCVC','$email','$price','$id','$address')";

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
    				$mail->addAddress(''. $email, 'Guilherme Linden'); 
					$mail->isHTML(true);
					$mail->Subject  = "Order confirmation BWM";
					$mail->Body = "Order confirmed on the value of $" . $price . "<br>This is your order id: " . $id . "<br>Thank you for your order :)";
					$mail->AltBody = "Order confirmed on the value of $" . $price . "\r\n This is your order id: " . $id ."Thank you for your order! \r\n :)";

					if (!$mail->send()) {
					    echo"<script language='javascript' type='text/javascript'>alert('An error occurred');window.location.href='index.php';</script>";
					} else {
					    echo"<script language='javascript' type='text/javascript'>alert('Purchase confirmed, details were sent by 	email');window.location.href='index.php';</script>";
					}
  			
				}	
			}

		}
	}

?>

<footer id="main-footer" class="t-borer">
			<p>All rights reserved to <a href="#">VIA University</a>.</p>
			<a href="#top">Back to top &raquo;</a>
		</footer>

</body>
</html>

