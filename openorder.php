<?php
include_once 'database/database.php';

session_start();

if(isset($_SESSION['user'])){
	$id = session_id();
}
else {
	echo"<script language='javascript' type='text/javascript'>alert('You must be logged on. Permission denied');window.location.href='index.php';</script>";
}

$orderid = $_GET['value'];
$closed = $_GET['closed'];
$open =  $_GET['open'];

$connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
mysql_select_db("bwm");

$sql = "UPDATE ORDERS SET ALREADYSENT = 0 WHERE ORDERID = '$orderid'";
mysql_query($sql);

header("Location:admin.php?closed=$closed&open=$open")
?>