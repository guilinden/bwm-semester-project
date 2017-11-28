<!DOCTYPE html>
<html>
<head>
	<title>Newsletter</title>
	<link rel="stylesheet" href="css/teste.css">
</head>
<body>
	<div class="navbar">
 		<a href="index.php">Home</a>
  		<a href="store.php">Store</a>
 	 	<a href="#aboutus.php">About us</a>
  		<a href="contact.php">Contact</a>
 	 	<a href="newsletter.php">NewsLetter</a>
	</div>
	<div class="topCheckout">
		<h1>Subscribe to our Newsletter!</h1>
	</div>
	<div class="buttonsCheckout">
		<form class="formPurchase" method="post" action="">
			<input type="text" name="firstName" class="email" placeholder="First Name">
			<br><br><input type="text" name="lastName" class="email" placeholder="Last Name">
			<br><br><input type="email" name="email" class="email" placeholder="Email">
		<br><br><br><button type="submit" name="enviar" class="purchase">Subscribe</button>
		</form>
	</div>

<?php
if(isset($_POST['enviar'])){

	$fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        // MailChimp API credentials
        $apiKey = #yourKEY;
        $listID = #yourID;
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
        
        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $fname,
                'LNAME'     => $lname
            ]
        ]);
        
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // store the status message based on response code
        if ($httpCode == 200) {
            echo"<script language='javascript' type='text/javascript'>alert('You are succesfully subscribed to BWM Newsletter');</script>"; 
        } else {
            switch ($httpCode) {
                case 214:
                    echo"<script language='javascript' type='text/javascript'>alert('You are already subscribed');</script>"; 
                    break;
                default:
                    echo"<script language='javascript' type='text/javascript'>alert('Ops, we had a problem');</script>"; 
                    break;
            }
        }

    }
}
?>

<footer id="main-footer" class="t-borer">
            <p>All rights reserved to <a class="footerLink" href="#">VIA University</a>.</p>
            <a class="footerLink" href="#top">Back to top &raquo;</a>
        </footer>

</body>
</html>

